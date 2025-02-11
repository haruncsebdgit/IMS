<?php

/**
 * User Controller.
 * php version 7.1.3
 *
 */

namespace App\Http\Controllers\Users;

use DB;
use Image; //Intervention Image
use Session;
use Validator;

use App\Models\User;
use App\Models\Upload;
use Illuminate\Http\Request;
use App\Models\RolePermission;

use App\Models\Settings\Division;
use App\Models\Settings\District;
use App\Models\Settings\UnionWard;
use App\Http\Controllers\Controller;
use App\Models\BaseUpload;
use App\Models\Settings\ThanaUpazila;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; //Laravel Filesystem
use App\Models\UploadImage as UploadImage;
use App\Models\LocationDataForFilter;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\OrganizationModel;
use App\Models\Settings\Organogram;
use App\Models\UserOrganogram;
use App\Models\UserProject;
use Cache;

/**
 * User Controller.
 * php version 7.1.3
 *
 * @category CMS/Admin
 */
class UserController extends Controller
{
    private $upload;
    private $baseUpload;
    public  $uploadPath;
    private $imageUpload;

    public static $uploadMaxSize;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->upload       = new Upload;
        $this->baseUpload   = new BaseUpload;
        $this->imageUpload = new UploadImage;
        $this->uploadPath   = 'user' . '/';

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function index()
    {
        $itemsPerPage = itemsPerPage();

        $_args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        // Push filter Parameters.
        $_args = filterParams(
            $_args,
            array(
                'name',
                'email',
                'role',
                'username',
                'division_id',
                'district_id',
                'thana_upazila_id',
                'union_ward_id'
            )
        );

        $users = User::getUsers($_args);

        $roles = RolePermission::roles();

        return view('users.index', compact('users', 'itemsPerPage', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function add()
    {
        $data = array();

        // User Role
        $registeredUserRoles = RolePermission::roles();

        $data['designations'] = CommonLabel::getCLWithKeyValue('designations');
        $data['assetLocation'] = CommonLabel::getCLWithKeyValue('asset-location');
        $data['userImage']    = '/images/placeholder-person.png';
        $data['placeHolderImage']    = url('/images/placeholder-person.png');
        $data['isShowEmployeeNameDesignation'] = 'd-none';

        return view('users.add', compact('registeredUserRoles'))->with($data);
    }

    /**
     * Mandate Location Fields based on User Level.
     *
     * @param array $inputs Form inputs.
     * @param array $rules  Default Rules.
     *
     * @access private
     *
     * @return array Modified Conditional Rules.
     */
    private function mandateUserLevelFields($inputs, $rules)
    {
        if (!empty($inputs['user_level'])) {
            $_user_level = $inputs['user_level'];
            if (in_array($_user_level, ['ddlg', 'df'], true)) {
                $rules['district_id'] = 'required|integer';
            } elseif ('ups' === $_user_level) {
                $rules['upazila_id'] = 'required|integer';
                $rules['union_id'] = 'required|integer';
            }
        }

        return $rules;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @see $this->mandateUserLevelFields();
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function save(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['created_by'] = Auth::id();

            // validate
            $rules = array(
                'name_en'        => 'required|string|max:255',
                'name_bn'        => 'string|max:255',
                'email'          => 'required|string|email|max:255|unique:users,email',
                'username'       => 'required|string|max:255|unique:users,username',
                'password'       => 'required|string|min:8|confirmed',
                'phone'          => 'nullable|string|max:20',
                'blood_group'    => 'nullable|string|max:20',
                'designation_id' => 'nullable|integer',
                'user_level'     => 'nullable|string|max:255',
                'is_active'      => 'boolean',
                'user_role'      => 'required',
            );

            $rules = $this->mandateUserLevelFields($inputs, $rules);

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {
                // Starting database transaction
                DB::beginTransaction();

                $inputs['password'] = Hash::make($inputs['password']);
                if (!empty($inputs['employee_image']) && !$request->file('user_image')) {
                    $inputs['user_image'] = $inputs['employee_image'];
                }

                $userInfo = User::create($inputs);

                //Start User Image Upload
                $uploadData = $this->uploadUserImage($request, $userInfo->id);
                //End User Image Upload

                if (isset($uploadData) && !empty($uploadData)) {
                    return redirect()->back()->withErrors($uploadData)->withInput($request->all);
                }

                updateUserMeta($userInfo->id, '_role', $inputs['user_role']);
                // Commit all transaction
                DB::commit();

                Session::flash('success', __('Saved Successfully!'));

                // Redirect to edit mode.
                return redirect(action('Users\UserController@edit', ['user_id' => $userInfo->id]));
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
     * Show the form for editing the specified resource.
     *
     * @param int $user_id User ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function edit($user_id)
    {
        $user     = User::findOrFail($user_id);
        $userRole = getUserMeta($user_id, '_role');

        $data['designations'] = CommonLabel::getCLWithKeyValue('designations');
        $data['assetLocation'] = CommonLabel::getCLWithKeyValue('asset-location');
        $data['userImage'] = '';
        $data['placeHolderImage']    = url('/images/placeholder-person.png');
        if (!empty($user->user_image)) {
            $data['userImage']    = url("/storage/uploads/images/" . $user->user_image);
        } else {
            $data['userImage']    = url('/images/placeholder-person.png');
        }

        // User Role
        $registeredUserRoles = RolePermission::roles();
        $data['isShowEmployeeNameDesignation'] = '';
        if ($user->user_type == 'external') {
            $data['isShowEmployeeNameDesignation'] = 'd-none';
        }

        $lang = config('app.locale');

        return view('users.edit', compact('user', 'registeredUserRoles', 'userRole'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @see $this->mandateUserLevelFields();
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();

            // Validate.
            $rules = array(
                'name_en'        => 'required|string|max:255',
                'name_bn'        => 'string|max:255',
                'email'          => 'required|string|email|max:255|unique:users,email,' . $inputs['id'],
                'phone'          => 'nullable|string|max:20',
                'blood_group'    => 'nullable|string|max:20',
                'designation_id' => 'nullable|integer',
                'user_level'     => 'nullable|string|max:255',
                'is_active'      => 'boolean',
            );

            if (!empty($inputs['password'])) {
                $rules = array_merge($rules, array('password' => 'required|string|min:8|confirmed'));
            }

            $rules = $this->mandateUserLevelFields($inputs, $rules);

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {
                // Starting database transaction.
                DB::beginTransaction();
                //dd($inputs);
                $userInfo = User::findorfail($inputs['id']);

                if (!empty($inputs['password'])) {
                    $inputs['password'] = Hash::make($inputs['password']);
                } else {
                    $inputs['password'] = $userInfo->password;
                }

                // Readonly field (username).
                $inputs['username'] = $userInfo->username;

                $inputs['updated_by'] = Auth::id();

                if (!empty($inputs['employee_image']) && !$request->file('user_image')) {
                    $inputs['user_image'] = $inputs['employee_image'];
                }
                $userInfo->update($inputs);

                //Start User Image Upload
                $uploadData = $this->uploadUserImage($request, $userInfo->id);
                //End User Image Upload

                if (isset($uploadData) && !empty($uploadData)) { //dd($uploadData);
                    return redirect()->back()->withErrors($uploadData)->withInput($request->all);
                }

                updateUserMeta($userInfo->id, '_role', $inputs['user_role']);

                // Commit all transaction
                DB::commit();

                Session::flash('success', __('Updated Successfully!'));

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
     * @param int $user_id User ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function delete($user_id)
    {
        try {
            DB::beginTransaction();
            $userModel = User::where('id', $user_id)->first();

            if ($userModel != null) {
                // Start This Option Only For Delete(Permanently Delete) Mode
                if (!empty($userModel->user_image)) {
                    //                self::removeUserImage($userModel->user_image);
                    $this->upload->deleteUpload($userModel->user_image);
                }

                $userModel->delete();

                DB::commit();

                // End This Option Only For Delete(Permanently Delete) Mode

                Session::flash('success', __('Deleted Successfully!'));

                return redirect()->back();
            } else {
                return redirect()->back()->withErrors('dangerMsg', __('Sorry, Please Try Again!'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    /**
     * All Registered Capabilities.
     *
     * @return array Modified or Default array or arguments.
     * --------------------------------------------------
     */
    public static function allCapabilities()
    {
        // Fetch capabilities from config/capabilities.php
        $capabilities = config('capabilities');

        return $capabilities;
    }

    /**
     * Add User Role wise Capabilities
     *
     * @param integer $user_id User ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function userCapabilities($user_id)
    {
        $data = array();

        $data['user'] = User::findOrFail($user_id);

        if (empty($data['user'])) {
            return abort('404');
        }

        $data['userRole'] = User::getUserRole($user_id);

        if (false == $data['userRole']) {
            $errors_array = array();
            $errors_array[] = __('The User Role is undefined for the :user. From here, please assign a user role first.', array('user' => $data['user']->name));

            if (hasUserCap('edit_users')) {
                return redirect(action('Users\UserController@edit', ['user_id' => $user_id]))
                    ->withErrors($errors_array);
            }
        }

        $data['userCaps'] = User::getUserCaps($user_id);
        $data['userLevel'] = Auth::user()->user_level;

        return view('users.roles.capabilities')->with($data);
    }

    /**
     * Store User Role wise Capabilities.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function saveUserCapabilities(Request $request)
    {
        try {
            $inputs = $request->all();

            $user_id = $inputs['user_id'];

            $_capabilities = isset($inputs['capabilities']) ? $inputs['capabilities'] : '';

            if (!empty($inputs['capabilities'])) {
                $_success_message = __('Saved Successfully');

                updateUserMeta($user_id, '_capabilities', $_capabilities);
            } else {
                $_success_message = __('Capabilities per User is removed, and Capabilities per Role is restored');

                deleteUserMeta($user_id, '_capabilities');
            }

            Session::flash('success', $_success_message);

            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Capabilities.
     *
     * Get only the permission keys and make a new array
     * with them.
     *
     * @see self::allCapabilities()
     *
     * @return array  Modified or Default array or arguments.
     * --------------------------------------------------
     */
    public static function capabilities()
    {
        $all_caps = self::allCapabilities();

        $capabilities = array();

        foreach ($all_caps as $module => $data) {
            foreach ($data as $caps) {
                foreach ($caps as $key => $val) {
                    $capabilities[] = $key;
                }
            }
        }

        return $capabilities;
    }


    /**
     * Store user meta data (Using AJAX).
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function ajaxMetaSave(Request $request)
    {
        $user_id    = $request->get('user_id');
        $meta_key   = $request->get('meta_key');
        $meta_value = $request->get('meta_value');

        if (empty($meta_value)) {
            deleteUserMeta($user_id, $meta_key);
            echo 'deleted';
        } else {
            updateUserMeta($user_id, $meta_key, $meta_value);
            echo 'updated';
        }
    }

    /**
     * Edit User Profile.
     *
     * @param integer $user_id User ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function editProfile($user_id)
    {
        $data = array();

        if ($user_id != Auth::id()) {
            if (hasUserCap('edit_users')) {
                Session::flash('success', __('Redirected to Edit User Information. You are authorized to Edit the User completely'));
                return redirect(action('Users\UserController@edit', ['user_id' => $user_id]));
            } else {
                return abort(403, 'Unauthorized action');
            }
        }

        $roles = RolePermission::roles();

        $data['user'] = User::select(
            'users.*',
            'users.name_en as name_en', // Important to explicitly mention to avoid conflicts.
            'users.name_bn as name_bn', // Important to explicitly mention to avoid conflicts.
        )
            ->where('users.id', $user_id)
            ->first();

        return view('users.profile', compact('roles'))->with($data);
    }


    /**
     * Update User Profile.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function updateProfile(Request $request)
    {
        try {
            $inputs = $request->all();

            // Validate.
            $rules = array(
                'name_en'     => 'required|string|max:255',
                'name_bn'     => 'string|max:255',
                'email'       => 'required|string|email|max:255|unique:users,email,' . $inputs['id'],
                'phone'       => 'nullable|string|max:20',
                'blood_group' => 'nullable|string|max:20',
            );

            if (!empty($inputs['password'])) {
                $rules = array_merge($rules, array('password' => 'required|string|min:8|confirmed'));
            }

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {
                // Starting database transaction
                DB::beginTransaction();

                $profileInfo = User::findorfail($inputs['id']);

                if (!empty($inputs['password'])) {
                    $inputs['password'] = Hash::make($inputs['password']);
                } else {
                    $inputs['password'] = $profileInfo->password;
                }

                // Readonly field (username).
                $inputs['username'] = $profileInfo->username;

                $inputs['updated_by'] = Auth::id();

                $profileInfo->update($inputs);

                //Start User Image Upload
                $uploadData = $this->uploadUserImage($request, $profileInfo->id);
                //End User Image Upload

                if (isset($uploadData)) {
                    return redirect()->back()->withErrors($uploadData)->withInput($request->all);
                }

                // Commit all transaction
                DB::commit();

                Session::flash('success', 'Updated Successfully!');
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
     * Store User Image Data Created resource in Storage.
     *
     * @param     $request
     * @param int $userInfoId
     *
     * @return string
     */
    public function uploadUserImage($request, $userInfoId)
    {
        $errors              = array();
        $inputs = [];
        if ($request->file('user_image')) {
            $inputs['user_image'] = $this->upload->uploadAndSaveFile($request->file('user_image'), 'user', $request->existing_user_image);

            if (isset($inputs['user_image']['_error']) && is_array($inputs['user_image']['_error'])) {
                $errors['user_image'] = concateValueToEachItemOfArray($inputs['image_ward_meeting']['_error'], __('Ward Meeting Photo'));
            } else {
                //dd($inputs['user_image']);
                $userImage = User::find($userInfoId);
                //dd($userImage);
                $userImage->user_image = $inputs['user_image']; // Save & update new_user_image path
                //$userImage->user_image = 'test'; // Save & update new_user_image path
                $userImage->save();
            }
        }

        return $errors;
    }

    /**
     * Get User Image Return Path.
     *
     * @param $userImageName
     * @param $fileNameToStore
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserImageReturnPath($userImageName, $fileNameToStore)
    {
        // THE IMAGE -----------------.
        // NOTE: we'll resize and overwrite them using intervention/image.
        Storage::put('public/uploads/images/' . $this->uploadPath . $fileNameToStore, fopen($userImageName, 'r+'), 'public');

        // Medium: Resize and Replace.
        $mediumPath = storage_path('app/public/uploads/images/' . $this->uploadPath) . $fileNameToStore;
        $mediumImg  = Image::make($mediumPath)->resize(
            500,
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
     * Delete the Physical Image from path.
     *
     * NOTE:
     * Public path with unlink() function won't work if
     * symlink is not activated.
     *
     * @param string $existing_image_path Path to the existing image.
     *
     * @return boolean True if succeed, False otherwise.
     * -----------------------------------
     */
    public static function removeUserImage($existing_image_path)
    {
        // Stripping out the leading slash to use with public_path().
        $modified_path = str_replace('/uploads/user_images', 'uploads/user_images', $existing_image_path);

        if (file_exists($modified_path)) {
            return unlink(public_path($modified_path));
        }

        return false;
    }

    public function getLoggedInUserList()
    {
        $itemsPerPage = itemsPerPage();
        $data['itemsPerPage'] = $itemsPerPage;
        $users = User::all();
        $users = $users->reject(function ($value, $key) {
            //dd($value->name_en);
            return !Cache::has('user-is-online-' . $value->id);
        });
        $data['users'] = $users;
        return view('users.logged-in-user-list', $data);
    }
}
