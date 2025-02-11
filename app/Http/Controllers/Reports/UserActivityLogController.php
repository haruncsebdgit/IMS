<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Reports;
use App\Models\AccessLog;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\SalaryReport;
use App\Models\Settings\CommonLabel;
use App\Models\User;

class UserActivityLogController extends Controller
{
    public function index()
    {
        $data = array();

        $data['userLists'] = User::getUserListWithDesignation();
        $data['dasignationList'] = CommonLabel::getCLWithKeyValue('designations');
       // dd($data['hrCategoryList']);
        Reports::indexMaster('reports.activity-log.index', $data);
    }

    public function show(Request $request)
    {
        $inputs = $request->all();
        $data   = array();

        $data['columns'] = isset($inputs['columns']) ? $inputs['columns'] : array();

        // Filename for exported files (optional)
        $data['filename'] = 'user-activity-log-report';
        $data['logs'] = AccessLog::getLogs($inputs);
        //dd($data['logs']);
        //$data['config'] = ['format' => 'A4-L', 'margin_left' => 3, 'margin_right' => 3,];

        Reports::showMaster("reports.activity-log.view", $inputs, $data);
    }

    public function getUserByDesignation($designationId)
    {
        return User::getUserListWithDesignation($designationId);
    }
}
