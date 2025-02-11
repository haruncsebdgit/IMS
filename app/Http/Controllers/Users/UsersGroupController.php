<?php

namespace App\Http\Controllers\Users;

use DB;
use Session;
use Validator;
use App\Models\User;
use App\Models\UsersGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UsersGroupController extends Controller
{
    /**
     * Users Group: List.
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemsPerPage = itemsPerPage();

        $usersGroupModel         = new UsersGroup;
        $data['usersGroupModel'] = $usersGroupModel;

        $args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        $data['usersGroupInfo'] = $usersGroupModel->getUsersGroupList($args);

        return view('users.users-group.list', compact('itemsPerPage'))->with($data);
    }

    /**
     * Users Group: Add.
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('users.users-group.add');
    }

    /**
     * Users Group: Store.
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['created_by'] = Auth::id();

            // Validate.
            $rules = array(
                'title' => 'required|string|max:255'
            );

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {

                // Starting database transaction
                DB::beginTransaction();

                $usersGroupData = UsersGroup::create($inputs);

                // Commit all transaction
                DB::commit();

                Session::flash('success', __('Saved Successfully!'));

                // Redirect to edit mode.
                $editPageUrl = action('Users\UsersGroupController@edit', ['user_group_id' => $usersGroupData->id]);

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
     * Users Group: Edit.
     * Show the form for editing the specified resource.
     *
     * @param int $user_group_id Users Group ID
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($user_group_id)
    {
        $usersGroupData = UsersGroup::findOrFail($user_group_id);

        $usersGroupModel         = new UsersGroup;
        $data['usersGroupModel'] = $usersGroupModel;

        $args = array(
            'order' => array('users.name_en' => 'asc')
        );

        $userModel        = new User;
        $data['userList'] = $userModel->getUsers($args);

        return view('users.users-group.edit', compact('usersGroupData'))->with($data);
    }

    /**
     * Users Group: Update.
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['updated_by'] = Auth::id();

            // Validate.
            $rules = array(
                'title' => 'required|string|max:255',
                'id'    => 'required'
            );

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {

                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {

                // Starting database transaction
                DB::beginTransaction();

                $usersGroupData = UsersGroup::findorfail($inputs['id']);
                $usersGroupData->update($inputs);

                //Start Update User Information
                $usersGroupId = (int)$usersGroupData->id;
                UsersGroup::deleteUserInfo($usersGroupId);

                if (!empty($inputs['user_id'])) {
                    $userData = array();
                    foreach ($inputs['user_id'] as $user_id) {
                        if (!empty($user_id)) {
                            $userData[] = $user_id;
                        }
                    }
                    UsersGroup::addUserInfo($usersGroupId, $userData);
                }
                //End Update User Information

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
     * Users Group: Delete.
     * Remove the specified resource from storage.
     *
     * @param int $user_group_id Users Group ID
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($user_group_id)
    {
        $usersGroupData = UsersGroup::find($user_group_id);

        $delete = $usersGroupData->delete();

        if ($delete == true) {
            return redirect()->back()->with('success', __('Deleted Successfully!'));
        }
    }
}
