<?php

namespace App\Models\Settings;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Employee Information Model.
 * php version >= 7.3
 *
 * @category Application
 * @package  MIS-NATP2
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'name_en',
        'name_bn',
        'employee_image',
        'organization_id',

        'designation_id',
        'father_name',
        'mother_name',
        'date_of_birth',

        'mobile',
        'nid',
        'email',
        'gender',

        'religion',
        'joining_date',
        'retirement_date',
        'employee_type_id',

        'employee_category_id',
        'employee_class_id',
        'is_active',
        'address',

        'division_id',
        'district_id',
        'upazila_id',
        'union_id',

        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * The Offices/Organograms that belong to the Employees.
     */
    public function organograms(){
        return $this->belongsToMany(Organogram::class, 'employee_organograms', 'employee_id', 'organogram_id');
    }

    /**
     * Get All list of Employees.
     *
     * @param array $args Array of arguments.
     *
     * @return object.
     * --------------------------------------------------
     */
    public static function getEmployeeLists($args = array())
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        // Session Organization ID
        $sessionOrganizationId = Auth::user()->organization_id;

        $defaults = array(
            'exclude'              => array(),
            'name'                 => null,
            'designation_id'       => null, // int|array
            'birth_date_from'      => null,
            'birth_date_to'        => null,
            'mobile'               => null,
            'nid'                  => null,
            'email'                => null,
            'gender'               => null, // int|array
            'joining_date_from'    => null,
            'joining_date_to'      => null,
            'retirement_date_from' => null,
            'retirement_date_to'   => null,
            'is_active'            => '',
            'order'                => array(
                'employees.id'    => 'desc',
                "employees.$name" => 'asc',
            ),
            'items_per_page'       => -1,
            'paginate'             => false, // ignored, if 'items_per_page' = -1
        );

        $arguments = parseArguments($args, $defaults);

        $employeeInfo = DB::table('employees');

        $employeeInfo = $employeeInfo->select(
            "employees.*",
            "emp_desi.$name AS designation",
            'emp_desi.name_en AS designation_name',
            "emp_typ.$name AS employee_type",
            'emp_typ.name_en AS employee_type_name',

            "emp_cate.$name AS employee_category",
            'emp_cate.name_en AS employee_category_name',
            "emp_cls.$name AS employee_class",
            'emp_cls.name_en AS employee_class_name'
        );

        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_desi', 'emp_desi.id', '=', 'employees.designation_id');
        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_typ', 'emp_typ.id', '=', 'employees.employee_type_id');
        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_cate', 'emp_cate.id', '=', 'employees.employee_category_id');
        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_cls', 'emp_cls.id', '=', 'employees.employee_class_id');
        if (!empty($arguments['exclude'])) {
            $employeeInfo = $employeeInfo->whereNotIn('employees.id', $arguments['exclude']);
        }

        if (!empty($arguments['name'])) {
            $search_name = $arguments['name'];
            $employeeInfo = $employeeInfo->where(function ($employeeInfo) use ($search_name) {
                $employeeInfo->where('employees.name_en', 'LIKE', '%' . $search_name . '%');
                $employeeInfo->orWhere('employees.name_bn', 'LIKE', '%' . $search_name . '%');
            });
        }

        if (!empty($arguments['designation_id'])) {
            $employeeInfo = $employeeInfo->where('employees.designation_id', $arguments['designation_id']);
        }

        // Date of Birth
        if (!empty($arguments['birth_date_from'])) {
            $birthDateForm = date("Y-m-d", strtotime($arguments['birth_date_from']));
        }

        if (!empty($arguments['birth_date_to'])) {
            $birthDateTo = date("Y-m-d", strtotime($arguments['birth_date_to']));
        }

        if (!empty($arguments['birth_date_from']) && empty($arguments['birth_date_to'])) {
            $employeeInfo = $employeeInfo->where('employees.date_of_birth', '>=', $birthDateForm);
        }
        // Only 'To' Date is Set
        if ($arguments['birth_date_from'] == null && $arguments['birth_date_to'] != null) {
            $employeeInfo = $employeeInfo->where('employees.date_of_birth', '<=', $birthDateTo);
        }
        if (!empty($arguments['birth_date_from']) && !empty($arguments['birth_date_to'])) {
            $employeeInfo = $employeeInfo->whereBetween('employees.date_of_birth', [$birthDateForm, $birthDateTo]);
        }

        if (!empty($arguments['mobile'])) {
            $employeeInfo = $employeeInfo->where('employees.mobile', $arguments['mobile']);
        }

        if (!empty($arguments['nid'])) {
            $employeeInfo = $employeeInfo->where('employees.nid', $arguments['nid']);
        }

        if (!empty($arguments['email'])) {
            $search_email = $arguments['email'];

            $employeeInfo = $employeeInfo->where(
                function ($employeeInfo) use ($search_email) {
                    $employeeInfo->where('employees.email', 'LIKE', "%$search_email%");
                }
            );
        }

        if (!empty($arguments['gender'])) {
            if ($arguments['gender'] === "male") {
                $employeeInfo = $employeeInfo->where('employees.gender', '=', 'male');
            } elseif ($arguments['gender'] === "female") {
                $employeeInfo = $employeeInfo->where('employees.gender', '=', 'female');
            } elseif ($arguments['gender'] === "third_gender") {
                $employeeInfo = $employeeInfo->where('employees.gender', '=', 'third_gender');
            }
        }

        // Joining Date
        if (!empty($arguments['joining_date_from'])) {
            $joiningDateForm = date("Y-m-d", strtotime($arguments['joining_date_from']));
        }

        if (!empty($arguments['joining_date_to'])) {
            $joiningDateTo = date("Y-m-d", strtotime($arguments['joining_date_to']));
        }

        if (!empty($arguments['joining_date_from']) && empty($arguments['joining_date_to'])) {
            $employeeInfo = $employeeInfo->where('employees.joining_date', '>=', $joiningDateForm);
        }
        // Only 'To' Date is Set
        if ($arguments['joining_date_from'] == null && $arguments['joining_date_to'] != null) {
            $employeeInfo = $employeeInfo->where('employees.joining_date', '<=', $joiningDateTo);
        }
        if (!empty($arguments['joining_date_from']) && !empty($arguments['joining_date_to'])) {
            $employeeInfo = $employeeInfo->whereBetween('employees.joining_date', [$joiningDateForm, $joiningDateTo]);
        }

        // Retirement Date
        if (!empty($arguments['retirement_date_from'])) {
            $retirementDateForm = date("Y-m-d", strtotime($arguments['retirement_date_from']));
        }

        if (!empty($arguments['retirement_date_to'])) {
            $retirementDateTo = date("Y-m-d", strtotime($arguments['retirement_date_to']));
        }

        if (!empty($arguments['retirement_date_from']) && empty($arguments['retirement_date_to'])) {
            $employeeInfo = $employeeInfo->where('employees.retirement_date', '>=', $retirementDateForm);
        }
        // Only 'To' Date is Set
        if ($arguments['retirement_date_from'] == null && $arguments['retirement_date_to'] != null) {
            $employeeInfo = $employeeInfo->where('employees.retirement_date', '<=', $retirementDateTo);
        }
        if (!empty($arguments['retirement_date_from']) && !empty($arguments['retirement_date_to'])) {
            $employeeInfo = $employeeInfo->whereBetween('employees.retirement_date', [$retirementDateForm, $retirementDateTo]);
        }

        if (!empty($arguments['is_active'])) {
            if ($arguments['is_active'] === 'active') {
                $employeeInfo = $employeeInfo->where('employees.is_active', 1);
            } elseif ($arguments['is_active'] === 'inactive') {
                $employeeInfo = $employeeInfo->where('employees.is_active', 0);
            }
        }

        foreach ($arguments['order'] as $orderBy => $order) {
            $employeeInfo = $employeeInfo->orderBy($orderBy, $order);
        }

        if ($arguments['items_per_page'] == '-1') {
            $employeeInfo = $employeeInfo->get();
        } else {
            if (true == $arguments['paginate']) {
                $employeeInfo = $employeeInfo->paginate(intval($arguments['items_per_page']));
            } else {
                $employeeInfo = $employeeInfo->take(intval($arguments['items_per_page']));
                $employeeInfo = $employeeInfo->get();
            }
        }

        return $employeeInfo;
    }

    /**
     * Get Employee Information by ID
     *
     * @param integer $employee_id Employee ID.
     *
     * @return object Employee Object
     * --------------------------------------------------------------------------
     */
    public function getEmployeeInfoById($employee_id)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $employeeInfo = DB::table('employees')
            ->select(
                "employees.*",

                "emp_desi.$name AS designation",
                'emp_desi.name_en AS designation_name',
                "emp_typ.$name AS employee_type",
                'emp_typ.name_en AS employee_type_name',

                "emp_cate.$name AS employee_category",
                'emp_cate.name_en AS employee_category_name',
                "emp_cls.$name AS employee_class",
                'emp_cls.name_en AS employee_class_name'
            );
        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_desi', 'emp_desi.id', '=', 'employees.designation_id');
        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_typ', 'emp_typ.id', '=', 'employees.employee_type_id');
        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_cate', 'emp_cate.id', '=', 'employees.employee_category_id');
        $employeeInfo = $employeeInfo->leftJoin('common_labels AS emp_cls', 'emp_cls.id', '=', 'employees.employee_class_id');

        // $employeeInfo = $employeeInfo->where('employees.is_active', 1);
        $employeeInfo = $employeeInfo->where('employees.id', $employee_id);
        $employeeInfo = $employeeInfo->first();

        return $employeeInfo;
    }
}
