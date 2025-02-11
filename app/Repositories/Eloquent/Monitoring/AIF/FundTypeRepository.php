<?php 

namespace App\Repositories\Eloquent\Monitoring\AIF;

use App\Models\Monitoring\AIF\FundType;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Monitoring\AIF\FundTypeRepositoryInterface;
use DB;

class FundTypeRepository extends BaseRepository implements FundTypeRepositoryInterface {
       /**
     * @var Model
     */
    protected $model;

    /**
     * FundTypeRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(FundType $model)
    {
        $this->model = $model;
    }

    /**
     * Save new fund type information or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param int $authId authenticated user id from session
     * @param $organizationId Authenticated user organization id (Such as DoF, DAE and DLS)
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $authId, $organizationId, $id = null)
    {
        $requestData['organization_id'] = $organizationId;
        if (is_null($id)) {
            $requestData['created_by'] = $authId;

            $fundTypes = $this->create($requestData);
            $this->saveOrganizationTypes($requestData, $fundTypes->id);
        } else {
            $requestData['updated_by'] = $authId;
            $this->update($id, $requestData);
            $this->saveOrganizationTypes($requestData, $id);
        }
        
    }
    /**
     * Saving eligible organization types
     */
    public function saveOrganizationTypes($requestData, $fundTypeId)
    {
        DB::table('aif_organization_type_fund_types')->where('fund_type_id', $fundTypeId)->delete();
        foreach($requestData['eligible_org_types'] as $item)
        {
            $data[] = [
                'eligible_organization_type' => $item,
                'fund_type_id' => $fundTypeId,
            ];
        }
        DB::table('aif_organization_type_fund_types')->insert($data);
        //dd($data);
    }

    /**
     * Get fund_types List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch fund_types otherwise null.
     * --------------------------------------------------
     */
    public function getAll($args = array())
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

        $fund_types = $this->model->query();

        if (!empty($arguments['name'])) {
            $fund_types = $fund_types ->where(function($q) use ($arguments){
                $q->where('aif_fund_types.name_en', 'LIKE', '%'.$arguments['name'].'%');
                $q->orWhere('aif_fund_types.name_bn', 'LIKE', '%'.$arguments['name'].'%');
            });
        }
        if (!empty($arguments['code'])) {
            $fund_types = $fund_types ->where('aif_fund_types.code', 'LIKE', '%'.$arguments['code'].'%');
        }


        foreach ($arguments['order'] as $orderBy => $order) {
            $fund_types = $fund_types->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $fund_types = $fund_types->get();
        } else {
            if (true == $arguments['paginate']) {
                $fund_types = $fund_types->paginate(intval($arguments['items_per_page']));
            } else {
                $fund_types = $fund_types->take(intval($arguments['items_per_page']));
                $fund_types = $fund_types->get();
            }
        }

        return $fund_types;
    }

    /**
     * Get Get Elligible Organization By AIF code.
     *
     * @param array $aifCode Array of arguments.
     *
     * @return array  of fetch elligible organization otherwise null.
     * --------------------------------------------------
     */
    public function getElligibleOrganizationByAifCode($aifCode)
    {
        if(empty($aifCode)){    // For fallback code
            $aifCode = 'aif-2';
        }
        $fundTypeId = $this->model->where('code', $aifCode)->first();
        if($fundTypeId) {
            $eligibleOrgTypes = DB::table('aif_organization_type_fund_types')
                    ->where('fund_type_id', $fundTypeId->id)
                    ->pluck('eligible_organization_type')->toArray();
            return  array_intersect_key(eligibleOrganizationType(), array_flip($eligibleOrgTypes ?? []));
        }

        return [];
        
    }

    /**
     * Get Fund type information By AIF code.
     *
     * @param string $aifCode String of arguments.
     *
     * @return Object  of fetch fund type info otherwise null.
     * --------------------------------------------------
     */
    public function getFundTypeInfoByCode($aifCode)
    {
        if(empty($aifCode)){    // For fallback code
            $aifCode = 'aif-2';
        }
        return $this->model->where('code', $aifCode)->first();
        
    }
}