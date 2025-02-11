<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Reports;
use App\Models\AccessLog;
use App\Models\Inventory\Stock;
use App\Models\Payroll\Payroll;
use App\Models\Payroll\SalaryReport;
use App\Models\Settings\CommonLabel;
use App\Models\User;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
        $data = array();

        $data['userLists'] = User::getUserListWithDesignation();
        $data['dasignationList'] = CommonLabel::getCLWithKeyValue('designations');
        $data['assetLocation'] = CommonLabel::getCLWithKeyValue('asset-location');
        $data['type'] = $request->get('type');
        Reports::indexMaster('reports.stock.index', $data);
    }

    public function show(Request $request)
    {
        $inputs = $request->all();
        $data   = array();

        $data['columns'] = isset($inputs['columns']) ? $inputs['columns'] : array();

        // Filename for exported files (optional)
        $data['filename'] = 'stock-report';
        if(!empty($inputs['type'])) {
            $view = 'reports.stock.room-wise-view';
            $data['stocks'] = Stock::getRoomWiseStockItems($inputs);
        } else {
            $view = 'reports.stock.view';
            $data['stocks'] = Stock::getStockItems($inputs);
        }
        //$data['config'] = ['format' => 'A4-L', 'margin_left' => 3, 'margin_right' => 3,];

        Reports::showMaster($view, $inputs, $data);
    }
}
