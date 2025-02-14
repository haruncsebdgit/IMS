<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Push user session data to form request data
     * Ex. Session Data: logged in user -> id, organization id, organogram id, project id etc
     * 
     * @param array $data 
     * @param bool $isCreatedBy If true then push auth id to created by index, otherwise updated by index
     * 
     * @author Mohammad Harun-Or-Rashid
     */
    public function pushUserSessionData(array $data, bool $isCreatedBy = true)
    {
        if($isCreatedBy) {
            $data['created_by'] = auth()->user()->id;
        } else {
            $data['updated_by'] = auth()->user()->id;
        }
        $data['organization_id'] = auth()->user()->organization_id;
        if( !empty(session('selected_organogram_id')) ) {
            $data['organogram_id'] = session('selected_organogram_id');
        }
        if( !empty(session('selected_project_id')) ) {
            $data['project_id'] = session('selected_project_id');
        }
        return $data;
    }

    public function validateReportParameter($params)
    {
        $params['project_id'] = [$params['project_id']];    // storing project_id as array because we use where In condition by project id
        if(!empty(auth()->user()->organization_id) ) {  // If user has organization id in session then replace parameter with session
            $params['organization_id'] = auth()->user()->organization_id;
        }
        $userAssignedProject = auth()->user()->projects()->get()->pluck('id')->toArray();
        if(!empty($userAssignedProject)) {
            $params['project_id'] = $userAssignedProject;
        }
    }
}
