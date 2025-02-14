<?php 

namespace App\Repositories\Monitoring\AIF;

use App\Repositories\EloquentRepositoryInterface;

/**
 * AIF Assessment repository interface
 * 
 * @author Mohammad Harun-Or-Rashid
 */
interface ImpactAssessmentInterface extends EloquentRepositoryInterface{
    /**
     * Save new assessment or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $id = null);

    /**
     * Get assessment List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch indicators otherwise null.
     * --------------------------------------------------
     */
    public function getAll($args = array());

    /**
     * Delete assessment.
     *
     * @param int $assessmentId.
     *
     * @return null.
     * --------------------------------------------------
     */
    public function delete($assessmentId);

    /**
     * Get common configuration setup data for impact assessment form.
     *
     *
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData();

    /**
     * Get assessment response data from fund allocation, cig member, po member etc scope
     *
     * @param [type] $allocationId
     * @return array array of assessment response data
     */
    public function getAssessmentResponseData($allocationId);

    /**
     * Get assessmentlatest  by Fund Type, sub project type id and allocation id
     *
     * @param int $fundType, $subProjectTypeId, $allocationId
     * @return object object of assessment response data
     */
    public function getImpactAssessment($fundType, $subProjectTypeId, $allocationId);
}
