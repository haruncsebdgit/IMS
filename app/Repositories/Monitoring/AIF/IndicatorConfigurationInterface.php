<?php 

namespace App\Repositories\Monitoring\AIF;

use App\Repositories\EloquentRepositoryInterface;

/**
 * AIF Assessment Indicator Configuration repository interface
 * 
 * @author Mohammad Harun-Or-Rashid
 */
interface IndicatorConfigurationInterface extends EloquentRepositoryInterface{
    /**
     * Save new assessment indicator configuration or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $id = null);

    /**
     * Get indicator configuration List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch indicators otherwise null.
     * --------------------------------------------------
     */
    public function getAll($args = array());

    /**
     * Delete indicator configuration.
     *
     * @param int $indicatorId.
     *
     * @return null.
     * --------------------------------------------------
     */
    public function delete($indicatorId);

    /**
     * Get common configuration setup data for indicator config form.
     *
     *
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData();


    /**
     * Get indicator configuration by fund type and sub project type id
     *
     * @param string $fundType
     * @param int $subProjectTypeId
     * @return Object indicator configuration list
     */
    public function getIndicatorConfigByFundTypeSubprojectType($fundType, $subProjectTypeId);
}
