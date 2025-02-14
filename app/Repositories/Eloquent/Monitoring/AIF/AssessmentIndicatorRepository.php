<?php 

namespace App\Repositories\Eloquent\Monitoring\AIF;

use App\Models\Monitoring\AIF\FundType;
use App\Models\Monitoring\AIF\Indicator;
use App\Models\Monitoring\AIF\IndicatorAnswer;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Monitoring\AIF\AssessmentIndicatorInterface;
use App\Repositories\Monitoring\AIF\FundTypeRepositoryInterface;
use DB;

/**
 * AIF Assessment Indicator repository
 * 
 * @author Mohammad Harun-Or-Rashid
 */
class AssessmentIndicatorRepository extends BaseRepository implements AssessmentIndicatorInterface {
       /**
     * @var Model
     */
    protected $model;

    /**
     * FundTypeRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Indicator $model)
    {
        $this->model = $model;
    }

    /**
     * Save new assessment indicator information or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $id = null)
    {
        if (is_null($id)) {

            $indicator = $this->create($requestData);
            $this->saveAnswers($requestData, $indicator->id);
        } else {
            $this->update($id, $requestData);
            $this->saveAnswers($requestData, $id);
        }
        
    }

    /**
     * Store indicator answers
     */
    public function saveAnswers($inputData, $indicatorId) 
    {
         // If empty answer list then delete all answers
        if (!isset($inputData['answer_name_en']) || empty($inputData['answer_name_en'])) {
            IndicatorAnswer::where('indicator_id', $indicatorId)->delete();
            return;
        }
       
        // Delete all answers except form answers list
        if (isset($inputData['answer_id']) && !empty($inputData['answer_id'])) {
            IndicatorAnswer::where('indicator_id', $indicatorId)
                    ->whereNotIn('id', $inputData['answer_id'])->delete();
        }
        foreach ($inputData['answer_name_en'] as $key=>$item) {
            $existingAnswerId = $inputData['answer_id'][$key] ?? null;
            $answers = [
                'indicator_id' => $indicatorId,
                'name_en' => $item,
                'name_bn' => $inputData['answer_name_bn'][$key],
                'mark_weight' => $inputData['mark_weight'][$key]
            ];

            IndicatorAnswer::updateOrCreate(['id'=>$existingAnswerId], $answers);
        }
    }

    /**
     * Get indicator List.
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
     * Delete indicator with respected answers.
     *
     * @param int $indicatorId.
     *
     * @return null.
     * --------------------------------------------------
     */
    public function delete($indicatorId)
    {
        IndicatorAnswer::where('indicator_id', $indicatorId)->delete();
        $this->deleteById($indicatorId);
    }
}
