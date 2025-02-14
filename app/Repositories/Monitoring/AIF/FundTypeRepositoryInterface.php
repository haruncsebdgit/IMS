<?php 

namespace App\Repositories\Monitoring\AIF;

use App\Repositories\EloquentRepositoryInterface;

/**
 * AIF fund type repository interface
 * 
 * @author Mohammad Harun-Or-Rashid
 */
interface FundTypeRepositoryInterface extends EloquentRepositoryInterface{
    /**
     * Save new fund type information or update existing once by $id
     * 
     * @param array $requestData Form input data
     * @param int $authId authenticated user id from session
     * @param $organizationId Authenticated user organization id (Such as DoF, DAE and DLS)
     * @param integer $id primary key of fund type information
     */
    public function saveOrUpdate($requestData, $authId, $organizationId, $id = null);

    /**
     * Get fund_types List.
     *
     * @param array $args Array of arguments.
     *
     * @return object Object of fetch fund_types otherwise null.
     * --------------------------------------------------
     */
    public function getAll($args = array());

    /**
     * Get Get Elligible Organization By AIF code.
     *
     * @param array $aifCode Array of arguments.
     *
     * @return array  of fetch elligible organization otherwise null.
     * --------------------------------------------------
     */
    public function getElligibleOrganizationByAifCode($aifCode);

    /**
     * Get Fund type information By AIF code.
     *
     * @param string $aifCode String of arguments.
     *
     * @return Object  of fetch fund type info otherwise null.
     * --------------------------------------------------
     */
    public function getFundTypeInfoByCode($aifCode);
}
