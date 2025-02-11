<?php 

namespace App\Repositories\Eloquent\Monitoring\AIF;

use App\Models\Monitoring\AIF\IndicatorAnswer;
use App\Models\Monitoring\AIF\IndicatorConfigDetails;
use App\Models\Monitoring\AIF\IndicatorConfiguration;
use App\Models\Settings\CommonLabel;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Monitoring\AIF\IndicatorConfigurationInterface;
use DB;

/**
 * AIF Assessment Indicator repository
 * 
 * @author Nazmul
 */
class IndicatorConfigurationRepository extends BaseRepository implements IndicatorConfigurationInterface {
       /**
     * @var Model
     */
    protected $model;

    /**
     * Indicator Configuration constructor.
     *
     * @param Model $model
     */
    public function __construct(IndicatorConfiguration $model)
    {
        $this->model = $model;
    }

    /**
     * Save new assessment indicator configuration or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $id = null)
    {
        if($requestData['is_active'] == 1) {
            $this->model->where('sub_project_type_id', $requestData['sub_project_type_id'])
                ->where('fund_type', $requestData['fund_type'])
                ->where('is_active', 1)
                ->update(['is_active'=>0]);
        }
        
        if (is_null($id)) {

            $indicatorConfig = $this->create($requestData);
            $this->saveIndicatorConfigDetails($requestData, $indicatorConfig->id);
        } else {
            $this->update($id, $requestData);
            $this->saveIndicatorConfigDetails($requestData, $id);
        }
        
    }

    /**
     * Store indicator details
     */
    public function saveIndicatorConfigDetails($inputData, $indicatorConfigId) 
    {
         // If empty config details list then delete all config details
        if (!isset($inputData['serial_en']) || empty($inputData['serial_en'])) {
            IndicatorConfigDetails::where('indicator_config_id', $indicatorConfigId)->delete();
            return;
        }
       
        // Delete all config details except form config details list
        if (isset($inputData['indicator_config_details_id']) && !empty($inputData['indicator_config_details_id'])) {
            IndicatorConfigDetails::where('indicator_config_id', $indicatorConfigId)
                    ->whereNotIn('id', array_values($inputData['indicator_config_details_id']))->delete();
        }

        foreach ($inputData['serial_en'] as $key=>$item) {
            $existingIndicatorConfigDetailsId = $inputData['indicator_config_details_id'][$key] ?? null;
            $indicatorConfigDetails = [
                'indicator_config_id' => $indicatorConfigId,
                'static_indicator_key' => $inputData['indicator_type'][$key] == 'static' ? $key : null,
                'indicator_id' => $inputData['indicator_type'][$key] == 'dynamic' ? $key : null,
                'serial_en' => $inputData['serial_en'][$key],
                'serial_bn' => $inputData['serial_bn'][$key],
                'order' => $inputData['order'][$key]
            ];

            IndicatorConfigDetails::updateOrCreate(['id'=>$existingIndicatorConfigDetailsId], $indicatorConfigDetails);
        }
    }

    /**
     * Get indicator configuration List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch indicators otherwise null.
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
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $indicatorConfig = $this->model->query()
                ->leftJoin('common_labels AS subProject', 'aif_indicator_configurations.sub_project_type_id', '=', 'subProject.id')
                ->select('aif_indicator_configurations.*',
                    "subProject.$name AS sub_project"
                );

        if (!empty($arguments['name'])) {
            $indicatorConfig = $indicatorConfig ->where(function($q) use ($arguments){
                $q->where('aif_fund_types.name_en', 'LIKE', '%'.$arguments['name'].'%');
                $q->orWhere('aif_fund_types.name_bn', 'LIKE', '%'.$arguments['name'].'%');
            });
        }
        if (!empty($arguments['sub_project_type_id'])) {
            $indicatorConfig = $indicatorConfig ->where('aif_indicator_configurations.sub_project_type_id', $arguments['sub_project_type_id']);
        }
        if (!empty($arguments['fund_type'])) {
            $indicatorConfig = $indicatorConfig ->where('aif_indicator_configurations.fund_type', $arguments['fund_type']);
        }


        foreach ($arguments['order'] as $orderBy => $order) {
            $indicatorConfig = $indicatorConfig->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $indicatorConfig = $indicatorConfig->get();
        } else {
            if (true == $arguments['paginate']) {
                $indicatorConfig = $indicatorConfig->paginate(intval($arguments['items_per_page']));
            } else {
                $indicatorConfig = $indicatorConfig->take(intval($arguments['items_per_page']));
                $indicatorConfig = $indicatorConfig->get();
            }
        }

        return $indicatorConfig;
    }

    /**
     * Delete indicator configuration with respected details.
     *
     * @param int $indicatorConfigId.
     *
     * @return null.
     * --------------------------------------------------
     */
    public function delete($indicatorConfigId)
    {
        IndicatorConfigDetails::where('indicator_config_id', $indicatorConfigId)->delete();
        $this->deleteById($indicatorConfigId);
    }

    /**
     * Get common configuration setup data for indicator config form.
     *
     *
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData()
    {
        $data['subProjectType'] = CommonLabel::getCLWithKeyValue('aif-sub-project-type');
        return $data;
    }

    /**
     * Get indicator configuration by fund type and sub project type id
     *
     * @param string $fundType
     * @param int $subProjectTypeId
     * @return Object indicator configuration list
     */
    public function getIndicatorConfigByFundTypeSubprojectType($fundType, $subProjectTypeId)
    {
        return $this->model->where('fund_type', $fundType)
                ->where('sub_project_type_id', $subProjectTypeId)
                ->where('is_active', 1)
                ->first();
    }
}