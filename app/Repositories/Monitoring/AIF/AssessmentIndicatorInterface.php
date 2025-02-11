<?php 

namespace App\Repositories\Monitoring\AIF;

use App\Repositories\EloquentRepositoryInterface;

/**
 * AIF Assessment Indicator repository interface
 * 
 * @author Nazmul
 */
interface AssessmentIndicatorInterface extends EloquentRepositoryInterface{
    /**
     * Save new assessment indicator information or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $id = null);

    /**
     * Get indicator List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch indicators otherwise null.
     * --------------------------------------------------
     */
    public function getAll($args = array());

    /**
     * Delete indicator with respected answers.
     *
     * @param int $indicatorId.
     *
     * @return null.
     * --------------------------------------------------
     */
    public function delete($indicatorId);
}