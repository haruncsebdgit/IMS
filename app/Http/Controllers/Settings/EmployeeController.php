<?php

namespace App\Http\Controllers\Settings;

use DB;
use Image; //Intervention Image
use Cache;

use Session;
use Response;
use Validator;

use App\Models\Upload;
use App\Models\BaseUpload;
use Illuminate\Http\Request;

use App\Models\Settings\Employee;
use App\Models\Settings\Organogram;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //Laravel Filesystem
use App\Models\Settings\OrganizationModel;
use App\Models\Settings\EmployeeOrganogram;

/**
 * Employee Information Controller Class.
 * php version >= 7.3
 *
 * @category Application
 * @package  MIS-NATP2
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class EmployeeController extends Controller
{
    private $upload;
    private $baseUpload;
    public  $uploadPath;

    public static $uploadMaxSize;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->upload     = new Upload;
        $this->baseUpload = new BaseUpload;
        $this->uploadPath = 'employee' . '/';

        /**
         * Maximum Upload Size.
         *
         * Maximum size of upload per image.
         *
         * Accepts: integer
         * ---------------------------------------------------------------------
         */
        self::$uploadMaxSize = (int)getOption('attachments_max_file_size'); // in binary bytes
    }

    /**
     * Default Image Extensions.
     *
     * Default accepted image extensions are mentioned here.
     * Will be applicable when per image extensions
     * are not available.
     *
     * Accepts: string
     *
     * Default: (string) 'jpg, jpeg, gif, png'
     * ---------------------------------------------------------------------
     */
    public static $defaultExtensions = 'jpg, jpeg, gif, png';

    /**
     * Change bytes to megabytes.
     *
     * @param  integer $bytes Bytes.
     * @param  boolean $round Boolean Value
     * @param  integer $roundTo Bytes.
     * @param  integer $roundMethod Round halves up.
     *
     * @return integer Megabytes.
     * --------------------------------------------------------------------------
     */
    public static function bytesToMb($bytes, $round = false, $roundTo = 2, $roundMethod = PHP_ROUND_HALF_UP)
    {
        $megaByteValue = ($bytes / 1024) / 1024;

        if ($round) {
            $megaByteValue = round($megaByteValue, $roundTo, $roundMethod);
        }

        return $megaByteValue;
    }

    /**
     * General Configuration Data.
     *
     * @param integer $employee_id Employee ID.
     * @access private
     *
     * @return array
     * --------------------------------------------------------------------------
     */
    private function generalConfigData($employee_id = null)
    {
        $data = [];
        // Get Designation List
        $data['designationList'] = getCommonLabels('designations');

        // Get Gender List
        $data['genderList'] = genders();

        // Get Religion List
        $data['religionList'] = religions();

        // Get Employee Type List
        $data['employeeTypeList'] = getCommonLabels('employee-type');

        // Get Employee Category List
        $data['employeeCategoryList'] = getCommonLabels('employee-category');

        // Get Employee Class List
        $data['employeeClassList'] = getCommonLabels('employee-class');

        return $data;
    }

    /**
     * Format Date.
     * @access private
     *
     * @param string $date Date
     *
     * @return string
     * --------------------------------------------------------------------------
     */
    private function dateFormat($date)
    {
        if ($date) {
            return date('Y-m-d', strtotime($date));
        } else {
            return null;
        }
    }

    /**
     * Validation Rules.
     *
     * @access private
     *
     * @return array
     * --------------------------------------------------------------------------
     */
    private function validateRules()
    {
        return array(
            'name_en'              => 'required|max:255',
            'name_bn'              => 'required|max:255',
            // 'employee_image'       => 'required',
            // 'organization_id'      => 'required',
            'designation_id'       => 'required',
            'father_name'          => 'required|max:255',
            'mother_name'          => 'required|max:255',
            'date_of_birth'        => 'required',
            'mobile'               => 'required',
            'nid'                  => 'required',
            'email'                => 'required',
            'gender'               => 'required',
            'religion'             => 'required',
            'joining_date'         => 'required',
            // 'retirement_date'      => 'required',
            'employee_type_id'     => 'required',
            'employee_category_id' => 'required',
            'employee_class_id'    => 'required',
            'is_active'            => 'required',
            'address'              => 'required',
            // 'division_id'          => 'required',
            // 'district_id'          => 'required',
            // 'upazila_id'           => 'required',
            // 'union_id'             => 'required',
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (hasUserCap(['view_employees', 'add_employees'])) {
            $itemsPerPage = itemsPerPage();
            $data         = [];

            $employeeModel         = new Employee();
            $data['employeeModel'] = $employeeModel;

            $args = array(
                'items_per_page' => $itemsPerPage,
                'paginate'       => true
            );

            // Push Filter/Search Parameters.
            $args = filterParams(
                $args,
                array(
                    'name'                 => 'name',
                    'designation_id'       => 'designation_id',
                    'birth_date_from'      => 'birth_date_from',
                    'birth_date_to'        => 'birth_date_to',
                    'mobile'               => 'mobile',
                    'nid'                  => 'nid',
                    'email'                => 'email',
                    'gender'               => 'gender',
                    'joining_date_from'    => 'joining_date_from',
                    'joining_date_to'      => 'joining_date_to',
                    'retirement_date_from' => 'retirement_date_from',
                    'retirement_date_to'   => 'retirement_date_to',
                    'is_active'            => 'is_active',
                )
            );

            $data = $this->generalConfigData();

            $data['employeeLists'] = $employeeModel->getEmployeeLists($args);

            return view('settings.employees.list', compact('itemsPerPage'))->with($data);
        } else {
            return abort(403, 'Unauthorized Action');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function add()
    {
        if (!hasUserCap('add_employees')) {
            return abort(401);
        }

        $data = $this->generalConfigData();

        return view('settings.employees.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function save(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['date_of_birth']   = $this->dateFormat($inputs['date_of_birth']);
            $inputs['joining_date']    = $this->dateFormat($inputs['joining_date']);
            $inputs['retirement_date'] = $this->dateFormat($inputs['retirement_date']);

            $inputs['created_by'] = Auth::id();

            // validate
            $rules = $this->validateRules();

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {
                // Starting database transaction
                DB::beginTransaction();

                $employeeInfo = Employee::create($inputs);

                // Start Employee Image Upload
                $uploadData = $this->uploadEmployeeImage($request, $employeeInfo->id);
                // End Employee Image Upload

                if (isset($uploadData)) {
                    return redirect()->back()->withErrors($uploadData)->withInput($request->all);
                }

                $cacheKey = 'employee_' . $employeeInfo->id;

                // Clear the specific cache.
                if (Cache::has($cacheKey)) {
                    Cache::forget($cacheKey);
                }

                // Commit all transaction
                DB::commit();

                Session::flash('success', __('Saved Successfully!'));

                // Redirect to add mode.
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred
            DB::rollBack();

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Show the Resource.
     *
     * @param integer $employee_id Employee ID.
     *
     * @return void
     * --------------------------------------------------------------------------
     */
    public function view($employee_id)
    {
        if (!hasUserCap('view_employees')) {
            return abort(401);
        }

        $data = [];

        $employeeModel       = new Employee();
        $employeeInformation = $employeeModel->getEmployeeInfoById($employee_id);
        return view('settings.employees.view', compact('employeeInformation'))->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $employee_id Employee ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function edit($employee_id)
    {
        if (!hasUserCap('edit_employees')) {
            return abort(401);
        }

        $data = $this->generalConfigData($employee_id);

        $employeeModel         = new Employee();
        $data['employeeModel'] = $employeeModel;

        $employeeInfo = Employee::findOrFail($employee_id);

        return view('settings.employees.edit', compact('employeeInfo'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['date_of_birth']   = $this->dateFormat($inputs['date_of_birth']);
            $inputs['joining_date']    = $this->dateFormat($inputs['joining_date']);
            $inputs['retirement_date'] = $this->dateFormat($inputs['retirement_date']);

            $inputs['updated_by'] = Auth::id();

            // validate
            $rules = $this->validateRules();

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {
                // Starting database transaction
                DB::beginTransaction();

                $employeeInfo = Employee::findorfail($inputs['id']);
                $employeeInfo->update($inputs);

                // Start Employee Image Upload
                $uploadData = $this->uploadEmployeeImage($request, $employeeInfo->id);
                // End Employee Image Upload

                if (isset($uploadData)) {
                    return redirect()->back()->withErrors($uploadData)->withInput($request->all);
                }

                $cacheKey = 'employee_' . $inputs['id'];

                // Clear the specific cache.
                if (Cache::has($cacheKey)) {
                    Cache::forget($cacheKey);
                }

                // Commit all transaction
                DB::commit();

                Session::flash('success', __('Updated Successfully!'));

                // Redirect to edit mode.
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred
            DB::rollBack();

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $employee_id Employee ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function delete($employee_id)
    {
        if (!hasUserCap('delete_employees')) {
            return abort(401);
        }

        try {
            // Starting database transaction
            DB::beginTransaction();

            $employeeModel = Employee::where('id', $employee_id)->first();

            if ($employeeModel != null) {

                // Start This Option Only For Delete(Permanently Delete) Mode
                if (!empty($employeeModel->employee_image)) {
                    $employeeModel->delete();

                    $this->upload->deleteUpload($employeeModel->employee_image);
                }else{
                    $employeeModel->delete();
                }

                $cacheKey = "employee_{$employee_id}";

                // Clear the specific cache.
                if (Cache::has($cacheKey)) {
                    Cache::forget($cacheKey);
                }

                // Commit all transaction
                DB::commit();

                Session::flash('success', __('Deleted Successfully!'));

                return redirect()->back();
            } else {
                return redirect()->back()->withErrors('dangerMsg', __('Sorry, Please Try Again!'));
            }
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred
            DB::rollBack();

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store Employee Image Data Created resource in Storage.
     *
     * @param     $request
     * @param int $employeeInfoId
     *
     * @return string
     */
    public function uploadEmployeeImage($request, $employeeInfoId)
    {
        $errors                  = array();
        $new_employee_image      = $request->file('employee_image');
        $existing_employee_image = $request->existing_employee_image;

        // Proceed with the default accepted images.
        $extensions = self::$defaultExtensions;

        // Get mime types from extensions.
        $accepted_mime_types = $this->baseUpload->mimeTypesFromExtensions($extensions);

        // Get Image size from Maximum Upload Size ( self::$uploadMaxSize ) method.
        $maximum_image_size = self::$uploadMaxSize;

        $image_size_msg = sprintf(__('Image Size exceeds %sMB'), self::bytesToMb($maximum_image_size, true));
        $image_type_msg = __('Image Type not supported');

        //Start Only Save When both new_employee_image & existing_employee_image are empty
        if (($new_employee_image == null) && ($existing_employee_image == null)) {
            //Start Save Employee Image
            $employeeImage = Employee::find($employeeInfoId);

            if ($employeeImage->employee_image) {
                $this->upload->deleteUpload($employeeImage->employee_image);
            }

            $employeeImage->employee_image = null; // save employee_image path when both are empty
            $employeeImage->save();
            //End Save Employee Image
        }
        //End Only Save When both new_employee_image & existing_employee_image are empty

        if (isset($new_employee_image) && !empty($new_employee_image)) {
            //Start Save & Update Employee Image Upload For new_employee_image & Only Save When existing_employee_image is empty

            // Get the mime type of the uploaded employee image.
            $new_mime_type = $new_employee_image->getClientMimeType();

            // Get filename with extension, eg. 'abc.jpg'.
            $filenameWithExtension = $new_employee_image->getClientOriginalName();

            // Get filename without extension, eg. 'abc'.
            $filenameWithoutExtension = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            // Get file extension, eg. 'jpg'.
            $fileExtension = $new_employee_image->getClientOriginalExtension();

            // If it's exceeds Maximum Image Size, don't upload it
            if ((filesize($new_employee_image) >= $maximum_image_size) || (filesize($new_employee_image) == 0)) {
                $errors['image_size'] = $image_size_msg;
            }

            // If it's not in the accepted MIME type list, don't upload it.
            if ((!in_array($new_mime_type, $accepted_mime_types)) && (!empty($new_mime_type))) {
                $errors['mime_type'] = $image_type_msg;
            }

            if (count($errors) === 0) {
                if (isset($new_employee_image)) {
                    // Filename to Store.
                    $fileNameToStore = $employeeInfoId . '-' . $this->baseUpload->sanitizeFilename($filenameWithoutExtension) . '-' . date("Ymd") . '-' . time() . '.' . strtolower($fileExtension); // Filename stored by filename, date, time & extension.

                    if (in_array($new_mime_type, $accepted_mime_types)) {
                        $employeeUploadImage = $this->getEmployeeImageReturnPath($new_employee_image, $fileNameToStore);

                        // Start Delete existing_employee_image before Updating new_employee_image
                        if (!empty($existing_employee_image) && ($employeeUploadImage !== $existing_employee_image)) {
                            $this->upload->deleteUpload($existing_employee_image);
                        }
                        // End Delete existing_employee_image before Updating new_employee_image

                        //Start Save & Update Employee Image
                        $employeeImage                 = Employee::find($employeeInfoId);
                        $employeeImage->employee_image = $employeeUploadImage; // Save & update new_employee_image path
                        $employeeImage->save();
                        //End Save & Update Employee Image
                    }
                }
            } else {
                return $errors;
            }
            //End Save & Update Employee Image Upload For new_employee_image & Only Save When existing_employee_image is empty
        } else {
            if ($request['remove_existing_employee_image'] == 'yes') {
                $this->upload->deleteUpload($existing_employee_image);

                $employeeImage                 = Employee::find($employeeInfoId);
                $employeeImage->employee_image = null; // save employee_image path when only existing_employee_image path is empty
                $employeeImage->save();
            } else {
                //Start Only Update Employee Image Upload For Existing Employee Image Path
                if (!empty($existing_employee_image) && ($new_employee_image == null)) {
                    if (isset($existing_employee_image)) {
                        $existing_employee_mime_type = pathinfo($existing_employee_image)['extension'];

                        if (array_key_exists($existing_employee_mime_type, $accepted_mime_types)) {
                            //Start Update Employee Image
                            $employeeImage                 = Employee::find($employeeInfoId);
                            $employeeImage->employee_image = $existing_employee_image; // Only update existing_employee_image path
                            $employeeImage->save();
                            //End Update Employee Image
                        }
                    }
                }
                //End only Update Employee Image Upload For Existing Employee Image Path
            }
        }
    }

    /**
     * Get Employee Image Return Path.
     *
     * @param $employeeImageName
     * @param $fileNameToStore
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmployeeImageReturnPath($employeeImageName, $fileNameToStore)
    {
        // THE IMAGE -----------------.
        // NOTE: we'll resize and overwrite them using intervention/image.
        Storage::put('public/uploads/images/' . $this->uploadPath . $fileNameToStore, fopen($employeeImageName, 'r+'), 'public');

        // Medium: Resize and Replace.
        $mediumPath = storage_path('app/public/uploads/images/' . $this->uploadPath) . $fileNameToStore;
        $mediumImg  = Image::make($mediumPath)->resize(
            3000,
            null,
            function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        );
        $mediumImg->save($mediumPath, 60);

        return $this->uploadPath . $fileNameToStore;
    }

    /**
     * Get Employee By Designation ID.
     *
     * @param string $designationId Designation ID.
     *
     * @return object.
     * --------------------------------------------------
     */
    public function getEmployeeByDesignation($designationId)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";
        return json_encode(Employee::where('designation_id', $designationId)->pluck($name, 'id'));
    }

    /**
     * Get Employee By Employee ID.
     *
     * @param string $employeeId Employee ID.
     *
     * @return object.
     * --------------------------------------------------
     */
    public function getEmployeeByEmployeeId($employeeId)
    {
        $lang = config('app.locale');
        $name = "name_{$lang}";

        $employee = Employee::find($employeeId);

        return json_encode([
            'name_en'        => $employee->name_en,
            'name_bn'        => $employee->name_bn,
            'email'          => $employee->email,
            'employee_image' => $employee->employee_image,
            'organogram_ids' => $employee->organograms()->get()->pluck('id')->toArray(),
        ]);
    }
}
