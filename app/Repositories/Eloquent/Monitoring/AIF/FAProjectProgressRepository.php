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
use App\Models\Settings\FinancialYear;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Monitoring\AIF\FAProjectProgressRepositoryInterface;
use App\Repositories\Monitoring\AIF\FundAllocationRepositoryInterface;
use App\Repositories\Monitoring\AIF\FundTypeRepositoryInterface;
use DB;

/**
 * Fund allocation sub project progress repository
 */
class FAProjectProgressRepository extends BaseRepository implements FAProjectProgressRepositoryInterface {
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
    public function __construct(FundAllocationProjectProgress $model)
    {
        $this->model = $model;
    }

    /**
     * Save new fund allocation sub project progress information or update existing once by $id
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

        if (is_null($id)) {
            $requestData['created_by'] = $authId;

            $this->create($requestData);
        } else {
            $requestData['updated_by'] = $authId;
            $this->update($id, $requestData);
        }
        
    }

    /**
     * Get fund allocation sub project progress List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch fund allocation sub project progress otherwise null.
     * --------------------------------------------------
     */
    public function getAll($fundAllocationId, $args = array())
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

        $fundAllocationProgress = $this->model::query()
                ->leftJoin('financial_years AS fy', 'aif_fa_project_progress.financial_year_id', '=', 'fy.id')
                ->leftJoin('aif_tools_technologies AS tools', 'aif_fa_project_progress.tools_technology_id', '=', 'tools.id')
                ->where('fund_allocation_id', $fundAllocationId)
                ->select('aif_fa_project_progress.*',
                    "fy.year_name",
                    "tools.technology_name AS tools_technology"
                );


        if (!empty($arguments['tools_technology_id'])) {
            $fundAllocationProgress = $fundAllocationProgress->where('aif_fa_project_progress.tools_technology_id', $arguments['tools_technology_id']);
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $fundAllocationProgress = $fundAllocationProgress->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $fundAllocationProgress = $fundAllocationProgress->get();
        } else {
            if (true == $arguments['paginate']) {
                $fundAllocationProgress = $fundAllocationProgress->paginate(intval($arguments['items_per_page']));
            } else {
                $fundAllocationProgress = $fundAllocationProgress->take(intval($arguments['items_per_page']));
                $fundAllocationProgress = $fundAllocationProgress->get();
            }
        }

        return $fundAllocationProgress;
    }

    /**
     * Get common configuration setup data for fund allocation project progress form.
     *
     * @param $fundAllocationId Fund allocation id
     * 
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData($fundAllocationId = null)
    {
        $data['financialYears'] = FinancialYear::getAllYearList();
        $data['toolsTechnology'] = AIFToolsTechnology::getTechnologyListById(FundAllocationTechnology::where('fund_allocation_id', $fundAllocationId)->pluck('tools_tech_goods_id'));
        return $data;
    }
}