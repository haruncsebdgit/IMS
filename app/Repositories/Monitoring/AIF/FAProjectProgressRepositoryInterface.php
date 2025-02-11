<?php 

namespace App\Repositories\Monitoring\AIF;

use App\Repositories\EloquentRepositoryInterface;

/**
 * AIF fund allocation Sub prject progress repository interface
 * 
 * @author Nazmul
 */
interface FAProjectProgressRepositoryInterface extends EloquentRepositoryInterface{
    /**
     * Save new fund allocation sub project progress information or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param int $authId authenticated user id from session
     * @param $organizationId Authenticated user organization id (Such as DoF, DAE and DLS)
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $authId, $organizationId, $id = null);

    /**
     * Get fund allocation sub project progress List.
     *
     * @param int $fundAllocationId Fund allocation Id.
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch fund allocation sub project progress otherwise null.
     * --------------------------------------------------
     */
    public function getAll($fundAllocationId, $args = array());

    /**
     * Get common configuration setup data for fund allocation project progress form.
     *
     * @param $fundAllocationId Fund allocation id
     *
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData($fundAllocationId = null);

}