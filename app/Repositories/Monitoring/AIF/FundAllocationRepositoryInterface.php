<?php 

namespace App\Repositories\Monitoring\AIF;

use App\Repositories\EloquentRepositoryInterface;

/**
 * AIF fund allocation repository interface
 * 
 * @author Mohammad Harun-Or-Rashid
 */
interface FundAllocationRepositoryInterface extends EloquentRepositoryInterface{
    /**
     * Save new fund allocation information or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param int $authId authenticated user id from session
     * @param $organizationId Authenticated user organization id (Such as DoF, DAE and DLS)
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $authId, $organizationId, $id = null);

    /**
     * Get Fund allocation List.
     *
     * @param array $args Array of arguments.
     * @param int $id Fund allocation id.
     *
     * @return object Object of fetch fund allocation otherwise null.
     * --------------------------------------------------
     */
    public function getAll($args = array(), $id = null);

    /**
     * Get common configuration setup data for fund allocation form.
     *
     * @param string $aifCode AIF code.
     * @param string $fundallocation Fund allocation info for current id in edit mode.
     *
     * @return array Array of fetch config data.
     * --------------------------------------------------
     */
    public function getConfigurationData($aifCode = null, $fundallocation = null);

    /**
     * Save tools technology details information
     * 
     * @param array $inputData Form input data
     * @param int $fundallocationId Fund allocation id
     * 
     * @return null
     */
    public function saveToolsTechnologyDetails($inputData, $fundallocationId);

    /**
     * Saving Tools technology Usage details
     * 
     * @param array $inputData Form input data
     * @param int $toolsTechnologyId Tools Technology Details id
     * 
     * @return null
     */
    public function saveToolsTechnologyUsageDetails($inputs, $toolsTechnologyId);

    /**
     * Delete fund allocation information with releated details scope
     * 
     * @param int $id Fund allocation id
     * 
     * @return null
     */
    public function delete($id);

    /**
     * Get sub project list
     * If $fundType is not null then return subproject list by fund typ wise
     *
     * @param string $fundType  'aif-1', 'aif-2'
     * @param int $unionId
     * @return void
     */
    public function getFundAllocatedSubprojectList($fundType = null, $unionId = null);
}
