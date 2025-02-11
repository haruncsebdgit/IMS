<?php

namespace App\Repositories\Monitoring;

interface CIGMemberDetailsInterface
{
    /**
     * Save pond information details for DoF
     * 
     */
    public function saveCIGMemberInfoDetails($inputData, $cigMemberId);
}
