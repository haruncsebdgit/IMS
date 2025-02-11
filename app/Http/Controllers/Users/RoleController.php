<?php

/**
 * User Role Controller.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */

namespace App\Http\Controllers\Users;

use DB;
use Cache;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Models\Settings\Option;
use App\Http\Controllers\Controller;
use App\Models\Settings\OrganizationModel;
use Illuminate\Support\Facades\Session;
use Auth;

/**
 * User Role Controller.
 * php version 7.1.3
 *
 * @category CMS/Admin
 * @package  LGSP3
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class RoleController extends Controller
{
    /**
     * User Roles: List.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function index()
    {
        $itemsPerPage = itemsPerPage();

        // Fetch all, not just active; but paginate to $itemsPerPage max.
        $userRolesInfo = RolePermission::getUserRolesInfo($itemsPerPage, true);

        return view('users.roles.index', compact('userRolesInfo', 'itemsPerPage'));
    }

    /**
     * User Roles: Add.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function add()
    {
        $data['userLevel'] = Auth::user()->user_level;
        $data['organizationId'] = Auth::user()->organization_id;
        $data['isDisableOrganization'] = $data['organizationId'] ? 'disabled' : '';
        $data['organizations']    = OrganizationModel::getOrganizationList();
        return view('users.roles.add', $data);
    }

    /**
     * User Roles: Store.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function save(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['slug'] = strtolower(Str::slug($inputs['slug'], '-'));

            // Validate.
            $rules = array(
                'slug'         => 'required|string|max:255|unique:roles_permissions,slug',
                'name'         => 'required|string|max:255',
                'capabilities' => 'required'
            );

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {

                // Starting database transaction
                DB::beginTransaction();

                // Serializing the permissions' array
                $inputs['permissions'] = Option::maybeSerialize($inputs['capabilities']);

                if(!empty(Auth::user()->organization_id)) {
                    $inputs['organization_id'] = Auth::user()->organization_id;
                }

                $userRolesData = RolePermission::create($inputs);

                $cacheKey = "user_role_{$inputs['slug']}";

                // Clear the specific cache.
                if (Cache::has($cacheKey)) {
                    Cache::forget($cacheKey);
                }

                // Commit all transaction
                DB::commit();

                Session::flash('success', __('Saved Successfully!'));

                // Redirect to edit mode.
                $editPageUrl = action('Users\RoleController@edit', ['role_id' => $userRolesData->id]);

                return redirect($editPageUrl);
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
     * User Roles: Edit.
     *
     * @param integer $userRoleId User Role ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function edit($userRoleId)
    {
        $userLevel = Auth::user()->user_level;
        $userRolesData = RolePermission::findOrFail($userRoleId);
        $organizations    = OrganizationModel::getOrganizationList();
        $organizationId = $userRolesData->organization_id;
        $isDisableOrganization = Auth::user()->organization_id ? 'disabled' : '';

        return view('users.roles.edit', compact('userRolesData', 'userLevel', 'organizations', 'organizationId', 'isDisableOrganization'));
    }

    /**
     * User Roles: Update.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();

            // Validate.
            $rules = array(
                'name'         => 'required|string|max:255',
                'id'           => 'required',
                'capabilities' => 'required'
            );

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {

                // Starting database transaction
                DB::beginTransaction();

                $userRolesData = RolePermission::findorfail($inputs['id']);

                // Serializing the permissions' array
                $inputs['permissions'] = Option::maybeSerialize($inputs['capabilities']);
                if(!empty(Auth::user()->organization_id)) {
                    $inputs['organization_id'] = Auth::user()->organization_id;
                }
                $userRolesData->update($inputs);

                $cacheKey = "user_role_{$userRolesData->slug}";

                // Clear the specific cache.
                if (Cache::has($cacheKey)) {
                    Cache::forget($cacheKey);
                }

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
     * User Roles: Delete.
     *
     * Remove the specified resource from storage.
     *
     * @param int $userRoleId User Role ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function delete($userRoleId)
    {
        $userRolesData = RolePermission::find($userRoleId);
        $delete = $userRolesData->delete();

        if ($delete == true) {
            return redirect()->back()->with('success', __('Deleted Successfully!'));
        }
    }
}
