<?php 

namespace App\Repositories\Eloquent\Monitoring\AIF;

use App\Models\Monitoring\AIF\FundAllocation;
use App\Models\Monitoring\AIF\FundAllocationProjectProgress;
use App\Models\Monitoring\AIF\FundAllocationTechnology;
use App\Models\Monitoring\AIF\FundType;
use App\Models\Monitoring\AIFToolsTechnology;
use App\Models\Monitoring\Cig;
use App\Models\Monitoring\CigMember;
use App\Models\Monitoring\PO\PoMmcMember;
use App\Models\Monitoring\PO\ProducerOrganization;
use App\Models\Monitoring\Saao;
use App\Models\Settings\CommonLabel;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Monitoring\AIF\FundAllocationRepositoryInterface;
use App\Repositories\Monitoring\AIF\FundTypeRepositoryInterface;
use DB;

class FundAllocationRepository extends BaseRepository implements FundAllocationRepositoryInterface {
    private $fundTypeRepository;
    /**
     * @var Model
     */
    protected $model;

    /**
     * FundTypeRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(FundAllocation $model, FundTypeRepositoryInterface $fundTypeRepository)
    {
        $this->model = $model;
        $this->fundTypeRepository = $fundTypeRepository;
    }

    /**
     * Save new fund allocation information or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param int $authId authenticated user id from session
     * @param $organizationId Authenticated user organization id (Such as DoF, DAE and DLS)
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $authId, $organizationId, $id = null)
    {
        //dd($requestData);
        $requestData['organization_id'] = $organizationId;

        if($requestData['beneficiary_type'] === 'cig') {
            $requestData['beneficiary_name_cig_id'] = $requestData['beneficiary_name_id'];
            $requestData['cig_member_id'] = $requestData['cig_po_member_id'];
        } else if ($requestData['beneficiary_type'] === 'po') {
            $requestData['beneficiary_name_po_id'] = $requestData['beneficiary_name_id'];
            $requestData['po_member_id'] = $requestData['cig_po_member_id'];
        }else if ($requestData['beneficiary_type'] === 'sao_leaf_ceal') {
            $requestData['beneficiary_name_sao_ceal_id'] = $requestData['beneficiary_name_id'];
        }
        
        $requestData = array_merge($requestData, $this->calculateGrantAndShareAmount($requestData));
        if (is_null($id)) {
            $requestData['created_by'] = $authId;

            $fundallocation = $this->create($requestData);

            $this->saveToolsTechnologyDetails($requestData, $fundallocation->id);
        } else {
            $requestData['updated_by'] = $authId;
            $fundallocation = $this->update($id, $requestData);

            $this->saveToolsTechnologyDetails($requestData, $id);
        }
        
    }

    /**
     * Calculate matching grant amount by Fund type setup info
     * Matching grant amount will be equal to matching grant percent amount from fund type setup
     * If Matching grant amount is greater than matching grant percent amount from fund type setup
     *  Then matching grant amount will be matching grant amount bdt from fund type setup
     * 
     * @param $inputs Form input field containt total project value, aif code etc
     */
    public function calculateGrantAndShareAmount($inputs)
    {
        $fundType = $this->fundTypeRepository->getFundTypeInfoByCode($inputs['aif_code']);

        $matchingGrantPercent = $fundType->matching_grant_percent ?? 0;
        $matchingGrantBdt = $fundType->matching_grant_bdt ?? 0;
        $matchigGrantAllocation = ($matchingGrantPercent * floatval($inputs['total_project_value']))/100;
        if($matchigGrantAllocation > $matchingGrantBdt) {
            $matchigGrantAllocation = $matchingGrantBdt;
        }
        $data['matching_grant_amount'] = $matchigGrantAllocation;
        $data['cig_po_ent_share_amount'] = floatval($inputs['total_project_value']) - $matchigGrantAllocation;

        return $data;
    }


    /**
     * Save tools technology details information
     * 
     * @param array $inputData Form input data
     * @param int $fundallocationId Fund allocation id
     * 
     * @return null
     */
    public function saveToolsTechnologyDetails($inputData, $fundallocationId) 
    {
        // If empty tools technology data then delete all tools technology items
        if (!isset($inputData['tools_tech']) || empty($inputData['tools_tech'])) {
            $fundAllocationTechId = FundAllocationTechnology::where('fund_allocation_id', $fundallocationId)->pluck('id');

            // Deleting Tools technology usage that is deleted from form
            DB::table('aif_fa_ttechnology_usages')->whereIn('tools_technology_id', $fundAllocationTechId)->delete();
            FundAllocationTechnology::destroy($fundAllocationTechId);
            return;
        }
        // Delete all items except form items
        if (isset($inputData['tools_tech_details_id']) && !empty($inputData['tools_tech_details_id'])) {
            $fundAllocationTechId = FundAllocationTechnology::where('fund_allocation_id', $fundallocationId)
                    ->whereNotIn('id', $inputData['tools_tech_details_id'])
                    ->pluck('id');
            // Deleting Tools technology usage that is deleted from form
            DB::table('aif_fa_ttechnology_usages')->whereIn('tools_technology_id', $fundAllocationTechId)->delete();
            FundAllocationTechnology::destroy($fundAllocationTechId);
        }

        foreach ($inputData['tools_tech'] as $key=>$item) {
            $toolsTechDetailsId = $item['id'] ?? null;
            $toolsTechInfo = [
                'fund_allocation_id' => $fundallocationId,
                'tools_tech_goods_id' => $item['tools_tech_goods_id'],
                'purchase_date' => $item['purchase_date'],
                'operation_start_date' => $item['operation_start_date'],
                'quantity' => $item['quantity'],
                'unit_id' => $item['unit_id'],
                'technology_usage_other' => $item['technology_usage_other'],
                'remarks' => $item['remarks'],
            ];
            if(!empty($toolsTechDetailsId)) {
                $fundallocationToolsTech = FundAllocationTechnology::find($toolsTechDetailsId);
                $fundallocationToolsTech->update($toolsTechInfo);
            } else {
                $fundallocationToolsTech = FundAllocationTechnology::create($toolsTechInfo);
            }

            $this->saveToolsTechnologyUsageDetails($item['tools_tech_goods_usage_id'], $fundallocationToolsTech->id);
        }
    }

    /**
     * Saving Tools technology Usage details
     * 
     * @param array $inputData Form input data
     * @param int $toolsTechnologyId Tools Technology Details id
     * 
     * @return null
     */
    public function saveToolsTechnologyUsageDetails($usageIds, $toolsTechnologyId)
    {
        $toolsTechDetails = FundAllocationTechnology::find($toolsTechnologyId);

        if (!empty($usageIds)) {
            $toolsTechDetails->toolsTechnologyUsage()->sync(explode(",", $usageIds));
        }
    }

    /**
     * Get Fund allocation List.
     *
     * @param array $args Array of arguments.
     * @param int $id Fund allocation id.
     *
     * @return object Object of fetch fund allocation otherwise null.
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

        // For DAE regions is Division instead of orginal divisions
        if (auth()->user()->organization_id == config('app.organization_id_dae')) {
            $regionDivision = 'regions AS div';
        } else {
            $regionDivision = 'divisions AS div';
        }

        $lang = config('app.locale');
        $name = "name_{$lang}";

        $fundAllocations = FundAllocation::query()
                ->leftJoin($regionDivision, 'aif_fund_allocations.division_id', '=', 'div.id')
                ->leftJoin('districts AS dis', 'aif_fund_allocations.district_id', '=', 'dis.id')
                ->leftJoin('thana_upazilas AS t', 'aif_fund_allocations.upazila_id', '=', 't.id')
                ->leftJoin('union_wards AS u', 'aif_fund_allocations.union_id', '=', 'u.id')
                ->leftJoin('cigs', 'aif_fund_allocations.beneficiary_name_cig_id', '=', 'cigs.id')
                ->leftJoin('common_labels AS cig_bank', 'cigs.bank_name_id', '=', 'cig_bank.id')
                ->leftJoin('producer_organizations AS po', 'aif_fund_allocations.beneficiary_name_po_id', '=', 'po.id')
                ->leftJoin('saaos', 'aif_fund_allocations.beneficiary_name_sao_ceal_id', '=', 'saaos.id')
                ->leftJoin('common_labels AS cl', 'aif_fund_allocations.sub_project_type_id', '=', 'cl.id')
                ->select('aif_fund_allocations.*',
                    "div.$name AS division_name",
                    "dis.$name AS district_name",
                    "t.$name AS upazila_name",
                    "u.$name AS union_name",
                    "cl.$name AS sub_project_type",
                    "cig_bank.$name AS cig_bank",
                    "cigs.cig_name",
                    "cigs.cig_address",
                    "cigs.registration_no",
                    "cigs.bank_account_no AS cig_bank_account_no",
                    "po.name AS po_name",
                    "saaos.name_of_saao",
                    "saaos.village AS saao_village"
                );

        if(!empty($id)) {
            $fundAllocations = $fundAllocations->where('aif_fund_allocations.id', $id);
        }
        
        if(!empty($arguments['code'])) {
            $fundAllocations = $fundAllocations->where('aif_fund_allocations.aif_code', $arguments['code']);
        }
        if(!empty($arguments['division_id'])) {
            $fundAllocations = $fundAllocations->where('aif_fund_allocations.division_id', $arguments['division_id']);
        }
        if(!empty($arguments['district_id'])) {
            $fundAllocations = $fundAllocations->where('aif_fund_allocations.district_id', $arguments['district_id']);
        }
        if(!empty($arguments['upazila_id'])) {
            $fundAllocations = $fundAllocations->where('aif_fund_allocations.upazila_id', $arguments['upazila_id']);
        }
        if(!empty($arguments['union_id'])) {
            $fundAllocations = $fundAllocations->where('aif_fund_allocations.union_id', $arguments['union_id']);
        }
        
        if(!empty($arguments['sub_project_type_id'])) {
            $fundAllocations = $fundAllocations->where('aif_fund_allocations.sub_project_type_id', $arguments['sub_project_type_id']);
        }


        foreach ($arguments['order'] as $orderBy => $order) {
            $fundAllocations = $fundAllocations->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $fundAllocations = $fundAllocations->get();
        } else {
            if (true == $arguments['paginate']) {
                $fundAllocations = $fundAllocations->paginate(intval($arguments['items_per_page']));
            } else {
                $fundAllocations = $fundAllocations->take(intval($arguments['items_per_page']));
                $fundAllocations = $fundAllocations->get();
            }
        }

        return $fundAllocations;
    }

    /**
     * Get common configuration setup data for fund allocation form.
     *
     * @param string $aifCode AIF code.
     * @param string $fundallocation Fund allocation info for current id in edit mode.
     *
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData($aifCode = null, $fundallocation = null)
    {
        $data['beneficiaryName'] = [];
        $data['cigPoMembers'] = [];
        $data['fundType'] = $this->fundTypeRepository->getFundTypeInfoByCode($aifCode);
        $data['organizations'] = $this->fundTypeRepository->getElligibleOrganizationByAifCode($aifCode);
        if($aifCode == 'aif-2') {
            $data['beneficiaryName'] = Cig::getCigList();
        }
        $data['subProjectType'] = CommonLabel::getCLWithKeyValue('aif-sub-project-type');
        $data['units'] = CommonLabel::getCLWithKeyValue('units');
        $data['toolsTechnology'] = AIFToolsTechnology::getTechnologyList();

        if($fundallocation) {
            if ($fundallocation->beneficiary_type === 'po') {
                $fundallocation->beneficiary_name_id = $fundallocation->beneficiary_name_po_id;
                $data['beneficiaryName'] = ProducerOrganization::getPOList();
                $fundallocation->cig_po_member_id = $fundallocation->po_member_id;
                $data['cigPoMembers'] = PoMmcMember::getCigNonCigMemberListByPoId($fundallocation->beneficiary_name_po_id);
                //dd($data['beneficiaryName']);
            } else if ($fundallocation->beneficiary_type === 'cig') {
                $fundallocation->beneficiary_name_id = $fundallocation->beneficiary_name_cig_id;
                $fundallocation->cig_po_member_id = $fundallocation->cig_member_id;
                $data['cigPoMembers'] = CigMember::getCigMemberListByCigId($fundallocation->beneficiary_name_cig_id);
            } else if ($fundallocation->beneficiary_type === 'sao_leaf_ceal') {
                $data['beneficiaryName'] = Saao::getArrayList();
            }

            $data['toolsTechnologyDetails'] = $fundallocation->toolsTechnologyDetails()->get();
            //dd($data['toolsTechnologyDetails']);
            $data['fundallocation'] = $fundallocation;
        }
        return $data;
    }

    /**
     * Delete fund allocation information with releated details scope
     * 
     * @param int $id Fund allocation id
     * 
     * @return null
     */
    public function delete($id)
    {
        $fundAllocationTechId = FundAllocationTechnology::where('fund_allocation_id', $id)
                    ->pluck('id');
        // Deleting Tools technology usage that is deleted from form
        DB::table('aif_fa_ttechnology_usages')->whereIn('tools_technology_id', $fundAllocationTechId)->delete();
        // Deleting Tools technology
        FundAllocationTechnology::destroy($fundAllocationTechId);
        // Deleting Sub project progress info
        FundAllocationProjectProgress::where('fund_allocation_id', $id)->delete();
        // Finally Deleting fund allocation
        $this->deleteById($id);
    }

    /**
     * Get sub project list
     * If $fundType is not null then return subproject list by fund typ wise
     *
     * @param string $fundType  'aif-1', 'aif-2'
     * @return void
     */
    public function getFundAllocatedSubprojectList($fundType = null, $unionId = null)
    {
        $lists = $this->model->query();
        if(!empty($fundType)) {
            $lists = $lists->where('aif_code', $fundType);
        }
        if(!empty($unionId)) {
            $lists = $lists->where('union_id', $unionId);
        }
        return $lists->pluck('sub_project_title', 'id');
    }
}