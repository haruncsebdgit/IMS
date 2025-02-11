<?php

namespace App\Http\Controllers;

use App\Models\Settings\Employee;
use Illuminate\Http\Request AS Requests;
use DataTables;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Html\Builder;

class EmployeePickerController extends Controller
{
    protected $htmlBuilder;

    public function __CONSTRUCT(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
    }
    public function showEmployeeList()
    {
        // $data['employeeLists'] = Employee::all();
        $data['html'] = $this->htmlBuilder
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => __("Employee Name (English)"), 'width' => '10%'])
            //->addColumn(['data' => 'name_bn', 'name' => 'name_bn', 'title' => __("Employee Name (Bengali)"), 'width' => '15%'])
            ->addColumn(['data' => 'name_bn', 'name' => 'name_bn', 'title' => __("Employee Name (Bengali)"), 'width' => '15%'])
            ->ajax([
                'url'  => url(Request::segment(1) . '/admin/employee-picker/read'),
                'type' => 'POST',
                'data' => 'function(d) {
                    var frm_data = $("form-filter").serializeArray();
                    $.each(frm_data, function(key, val) {
                         d[val.name] = val.value;
                    });
                 }',
            ])
            ->parameters([
                'searching'  => true,
                'responsive' => true,
                'processing' => true,
                'serverSide' => true,
                'stateSave'  => true,

                'pagingType' => 'full_numbers',
                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'language'   => [
                    'info'           => "Showing page _PAGE_ of _PAGES_",
                    'loadingRecords' => "Please wait - loading...",
                    'paginate'       => [
                        'first'    => 'First',
                        'last'     => 'Last',
                        'next'     => '&rarr;',
                        'previous' => '&larr;',
                    ],
                ],
            ]);
            //dd(url('admin/employee-picker/read'));
        return view('employee-picker.list', $data);
    }

    public function read(Requests $request)
    {
        //return $request->all();
        //echo json_encode($request->search);
        $lang = config('app.locale');
        $name = "name_{$lang}";
        $employeeLists = Employee::query();

        $datatable = DataTables::of($employeeLists)
            ->addColumn('action', function ($employeeLists) use($name) {
                return '<button type="button" class="employee-list btn btn-link" data-name="'. $employeeLists->$name . '"data-id="' . $employeeLists->id . '">'. $employeeLists->name_en .'</button>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $query->where('employees.name_en', 'LIKE', '%' . "{$request->search['value']}" . '%');
                    //$query->where('assessment.factory_id', '=', "{$request->get('factory_id')}");
                }
            });

        /* $datatable = $datatable->addColumn('action', function ($capInfo) {
            $this->btnPermission = null;
            if (SentinelAuth::check('rtm.trans.cap_upload_excel.view')) {
                $this->btnPermission .= '<a href="/rtm/cap-info/' . $capInfo->id . '/view" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-folder-open mr-5"></i> ' . trans('rtm/cap_info.btn_view') . '</a>';
            }
            if (SentinelAuth::check('rtm.trans.cap_upload_excel.del')) {
                $this->btnPermission .= ' <button type="button" id="' . $capInfo->id . '" class="delete-user btn btn-xs btn-primary"> <i class="glyphicon glyphicon-trash mr-5"></i>' . trans('rtm/cap_info.btn_delete') . '</button>';
            }

            return $this->btnPermission;

        }); */

        $datatable = $datatable->editColumn('id', '{!!$id!!}')
            ->setRowId('id')
            ->setRowData([
                'id' => 'test',
            ])
            ->make(true);

        return $datatable;
    }
}
