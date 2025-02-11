<?php

namespace App\Repositories\Eloquent\Monitoring\AIF;

use App\Models\Monitoring\AIF\FundAllocationProjectProgress;
use DB;
use App\Models\Settings\Region;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\UnionWard;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\ThanaUpazila;
use App\Repositories\Eloquent\BaseRepository;
use App\Models\Monitoring\AIF\ImpactAssessment;
use App\Models\Monitoring\AIF\IndicatorConfigDetails;
use App\Models\Monitoring\AIF\IndicatorConfiguration;
use App\Models\Monitoring\AIF\ImpactAssessmentDetails;
use App\Models\Monitoring\Cig;
use App\Models\Monitoring\CigMember;
use App\Repositories\Monitoring\AIF\ImpactAssessmentInterface;
use App\Repositories\Monitoring\AIF\FundAllocationRepositoryInterface;

/**
 * AIF Assessment Indicator repository
 *
 * @author Nazmul
 */
class ImpactAssessmentRepository extends BaseRepository implements ImpactAssessmentInterface {
       /**
     * @var Model
     */
    protected $model;
    private $fundAllocationRepository;

    /**
     * constructor.
     *
     * @param Model $model
     */
    public function __construct(ImpactAssessment $model, FundAllocationRepositoryInterface $fundAllocationRepository)
    {
        $this->model = $model;
        $this->fundAllocationRepository = $fundAllocationRepository;
    }

    /**
     * Save new assessment or update existing once by $id
     *
     * @param array $requestData Form input data
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $id = null)
    {
        if (is_null($id)) {

            $assessment = $this->create($requestData);
            $this->saveAssessmentDetails($requestData, $assessment->id);
        } else {
            $this->update($id, $requestData);
            $this->saveAssessmentDetails($requestData, $id);
        }

    }

    /**
     * Store assessment details
     */
    public function saveAssessmentDetails($inputData, $assessmentId)
    {
        if (!isset($inputData['response']) || empty($inputData['response'])) {
            return;
        }

        // First delete all assessment details
        ImpactAssessmentDetails::where('assessment_id', $assessmentId)->delete();

        foreach ($inputData['response'] as $key=>$item) {
            if (empty($item)) {
                continue;
            }
            $assessmentDetails = [
                'assessment_id' => $assessmentId,
                'assess_config_details_id' =>  $key ,
                'assessment_response' => $item
            ];

            ImpactAssessmentDetails::create($assessmentDetails);
        }
    }

    /**
     * Get assessment List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch indicators otherwise null.
     * --------------------------------------------------
     */
    public function getAll($args = array(), $id = null)
    {
        $defaults = array(
            'exclude'           => array(),
            'order'             => array(
                'id'      => 'desc'
            ),
            'items_per_page' => -1,
            'paginate'       => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $assessment = $this->model->query()
                ->leftJoin('aif_fund_allocations AS fa', 'aif_impact_assessments.sub_project_id', '=', 'fa.id')
                ->leftJoin('common_labels AS subProjectType', 'aif_impact_assessments.sub_project_type_id', '=', 'subProjectType.id')
                ->select('aif_impact_assessments.*',
                    "fa.sub_project_title",
                    "subProjectType.$name AS sub_project_type"
                );

        if (!empty($id)) {
            $assessment = $assessment ->where('aif_impact_assessments.id', $id);
        }

        if (!empty($arguments['name'])) {
            $assessment = $assessment ->where(function($q) use ($arguments){
                $q->where('aif_fund_types.name_en', 'LIKE', '%'.$arguments['name'].'%');
                $q->orWhere('aif_fund_types.name_bn', 'LIKE', '%'.$arguments['name'].'%');
            });
        }
        if (!empty($arguments['sub_project_type_id'])) {
            $assessment = $assessment ->where('aif_impact_assessments.sub_project_type_id', $arguments['sub_project_type_id']);
        }
        if (!empty($arguments['fund_type'])) {
            $assessment = $assessment ->where('aif_impact_assessments.fund_type', $arguments['fund_type']);
        }
        if (!empty($arguments['sub_project_id'])) {
            $assessment = $assessment ->where('aif_impact_assessments.sub_project_id', $arguments['sub_project_id']);
        }


        foreach ($arguments['order'] as $orderBy => $order) {
            $assessment = $assessment->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $assessment = $assessment->get();
        } else {
            if (true == $arguments['paginate']) {
                $assessment = $assessment->paginate(intval($arguments['items_per_page']));
            } else {
                $assessment = $assessment->take(intval($arguments['items_per_page']));
                $assessment = $assessment->get();
            }
        }

        return $assessment;
    }

    /**
     * Delete assessment.
     *
     * @param int $assessmentId.
     *
     * @return null.
     * --------------------------------------------------
     */
    public function delete($assessmentId)
    {
        ImpactAssessmentDetails::where('assessment_id', $assessmentId)->delete();
        $this->deleteById($assessmentId);
    }

    /**
     * Get common configuration setup data for impact assessment form.
     *
     *
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData()
    {
        $data['subProjectType'] = CommonLabel::getCLWithKeyValue('aif-sub-project-type');
        $data['subProjects'] = $this->fundAllocationRepository->getFundAllocatedSubprojectList();
        return $data;
    }

    /**
     * Get assessment response data from fund allocation, cig member, po member etc scope
     *
     * @param [type] $allocationId
     * @return array array of assessment response data
     */
    public function getAssessmentResponseData($allocationId)
    {
        $data['fundAllocationInfo'] = $this->fundAllocationRepository->getAll([], intval($allocationId))[0];
        $data['fundAllocationProgress'] = FundAllocationProjectProgress::where('fund_allocation_id', $allocationId)
                                            ->orderBy('id', 'desc')->first();
        $data['totalCigMember'] = CigMember::getTotalMemberByCIG($data['fundAllocationInfo']->beneficiary_name_cig_id);
        $data['totalFemaleCigMember'] = CigMember::getTotalMemberByCIG($data['fundAllocationInfo']->beneficiary_name_cig_id, 'female');
        //dd($data['cigBalance']);

        $data['village'] = '';
        $data['bankAccountNo'] =  '';
        $data['bankName'] =  '';
        $data['cigBalance'] = "";
        $data['poEntSaaoName'] = "";
        if($data['fundAllocationInfo']->beneficiary_type === 'cig') {
            $data['village'] = $data['fundAllocationInfo']->cig_address;
            $data['bankAccountNo'] =  $data['fundAllocationInfo']->cig_bank_account_no;
            $data['bankName'] =  $data['fundAllocationInfo']->cig_bank;
            $data['bankName'] =  $data['fundAllocationInfo']->cig_bank;
            $data['cigBalance'] = Cig::getCigDetailsList(auth()->user()->organization_id, ['cig_id'=>$data['fundAllocationInfo']->beneficiary_name_cig_id])[0]->balance ?? 0;

        } else if ($data['fundAllocationInfo']->beneficiary_type === 'po') {
            $data['poEntSaaoName'] = $data['fundAllocationInfo']->po_name;
        }else if ($data['fundAllocationInfo']->beneficiary_type === 'sao_leaf_ceal') {
            $data['poEntSaaoName'] = $data['fundAllocationInfo']->name_of_saao;
            $data['village'] = $data['fundAllocationInfo']->saao_village;
        }else if ($data['fundAllocationInfo']->beneficiary_type === 'enterpreneurs') {
            $data['village'] = $data['fundAllocationInfo']->enterpreneur_address;
            $data['poEntSaaoName'] = $data['fundAllocationInfo']->beneficiary_name_enterpreneur;
        }

        if(auth()->user()->organization_id == config('app.organization_id_dae')) {
            $data['divisions'] = Region::getRegionsListArray();
        } else {
            $data['divisions'] = Division::getDivisionListArray();
        }

        if( !empty($data['fundAllocationInfo']->division_id)) {
            $data['districts'] = District::getDistrictListByDivisionId($data['fundAllocationInfo']->division_id);
        }

        if( !empty($data['fundAllocationInfo']->district_id)) {
            $data['upazilas'] = ThanaUpazila::getDistrictWIseThanaUpazillaListWithKeyValuePair($data['fundAllocationInfo']->district_id);
        }

        if( !empty($data['fundAllocationInfo']->upazila_id)) {
            $data['unions'] = UnionWard::getUnionListByUpazilaId($data['fundAllocationInfo']->upazila_id);
        }
        return $data;
    }

    /**
     * Get assessmentlatest  by Fund Type, sub project type id and allocation id
     *
     * @param int $fundType, $subProjectTypeId, $allocationId
     * @return object object of assessment response data
     */
    public function getImpactAssessment($fundType, $subProjectTypeId, $allocationId)
    {
        return $this->model->where('fund_type', $fundType)
                        ->where('sub_project_type_id', $subProjectTypeId)
                        ->where('sub_project_id', $allocationId)
                        ->latest()
                        ->first();
    }
}
