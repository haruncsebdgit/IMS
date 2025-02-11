<?php

namespace App\Http\Controllers\Settings;

use DB;
use Session;
use Validator;
use Response;
use Image;
use App\Models\Upload;
use App\Models\BaseUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\OrganizationModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

/**
 * Organization Controller Class.
 *
 * @category Application
 * @package  NATP-2 (National Agricultural Technology Program- Phase II)
 * @author   Ariful Islam Srabon<arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd
 */
class OrganizationController extends Controller
{
    private $upload;
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->upload       = new Upload;
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
            'name_en'  => 'required|max:255',
            'name_bn'  => 'required|max:255',
        );
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (hasUserCap(['view_organizations', 'add_organizations'])) {
            $itemsPerPage = itemsPerPage();

            $organizationModel         = new OrganizationModel;
            $data['organizationModel'] = $organizationModel;

            $args = array(
                'items_per_page' => $itemsPerPage,
                'paginate'       => true
            );

            // Push Filter/Search Parameters.
            $args = filterParams(
                $args,
                array(
                    'organization_name' => 'name',
                    'organization_code' => 'code',
                    'is_active'         => 'is_active',
                )
            );


            $data['organizationsList'] = $organizationModel->getOrganizationsList($args);
            $data['organizationCode'] = getOrganizationCode();

            return view('settings.organization.list', compact('itemsPerPage'))->with($data);
        } else {
            return abort(403, 'Unauthorized Action');
        }
    }


    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        if (!hasUserCap('add_organizations')) {
            return abort(401);
        }

        $data                       = array();
        $organizationModel         = new OrganizationModel;
        $data['organizationModel'] = $organizationModel;
        $data['organizationCode'] = getOrganizationCode();

        return view('settings.organization.add')->with($data);
    }

    /**
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
            $id = OrganizationModel::getOrganizationIdByCode($inputs['code']);
            if(!empty($id)) {
                $inputs['id'] = $id;
            }
            
            $logo_image = $request->file('logo');
            $banner_image = $request->file('banner');
            $inputs['created_by'] = Auth::id();
            //dd($inputs);

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

               

                if(!empty($logo_image)){
                    $inputs['logo'] = $this->upload->uploadAndSaveFile( $logo_image, $inputs['code'] );
                }

                if(!empty($banner_image)){
                    $inputs['banner'] = $this->upload->uploadAndSaveFile( $banner_image, $inputs['code'] );
                }
                
                if(isset($inputs['banner']['_error']) || isset($inputs['logo']['_error'])){
                    if (isset($inputs['banner']['_error'])) {
                        $err['error_organization_banner_image'] = concateValueToEachItemOfArray($inputs['banner']['_error'], __('Photo of the Organization Banner.'));
                    }
                    if (isset($inputs['logo']['_error'])) {
                        $err['error_organization_logo_image'] = concateValueToEachItemOfArray($inputs['logo']['_error'], __('Photo of the Organization Logo.'));
                    }
    
                    if (!empty($err)) {
                        return redirect()->back()->withErrors($err)->withInput($request->all);
                    }

                }else{
                    $organizationInfo = OrganizationModel::create($inputs);
                }
                
                // Commit all transaction
                DB::commit();

                Session::flash('success', 'Saved Successfully!');

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
     * Show the form for editing the specified resource.
     *
     * @param int $organization_id Financial Year ID
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($organization_id)
    {
        if (!hasUserCap('edit_organizations')) {
            return abort(401);
        }

        $theOrganizationInfo = OrganizationModel::findOrFail($organization_id);
        
        $organizationModel         = new OrganizationModel;
        $data['organizationModel'] = $organizationModel;
        $data['organizationCode'] = getOrganizationCode();

        return view('settings.organization.edit', compact('theOrganizationInfo'))->with($data);
    }

    /**
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
            $logo_image = $request->file('logo');
            $banner_image = $request->file('banner');

            
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
           
                $organizationInfo = OrganizationModel::findorfail($inputs['id']);


                if(!empty($logo_image)){
                    $inputs['logo'] = $this->upload->uploadAndSaveFile( $logo_image, $inputs['code'] );
                }

                if(!empty($banner_image)){
                    $inputs['banner'] = $this->upload->uploadAndSaveFile( $banner_image, $inputs['code'] );
                }

                if(isset($inputs['banner']['_error']) || isset($inputs['logo']['_error'])){
                    if (isset($inputs['banner']['_error'])) {
                        $err['error_organization_banner_image'] = concateValueToEachItemOfArray($inputs['banner']['_error'], __('Photo of the Organization Banner.'));
                    }
                    if (isset($inputs['logo']['_error'])) {
                        $err['error_organization_logo_image'] = concateValueToEachItemOfArray($inputs['logo']['_error'], __('Photo of the Organization Logo.'));
                    }
    
                    if (!empty($err)) {
                        return redirect()->back()->withErrors($err)->withInput($request->all);
                    }

                }

             
            
                $organizationInfo->update($inputs);

            

                // Commit all transaction
                DB::commit();

                Session::flash('success', 'Updated Successfully!');

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
     * @param int $organization_id Organization ID
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($organization_id)
    {
        if (!hasUserCap('delete_organizations')) {
            return abort(401);
        }

        $organizationInfo = OrganizationModel::where('id', $organization_id)->first();

        if ($organizationInfo != null) {
            $organizationInfo->delete();

            Session::flash('success', __('Deleted Successfully!'));

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('dangerMsg', __('Sorry, Please Try Again!'));
        }
    }



   /**
     * Delete the specified resource in storage Using Ajax.
     *
     * @param int $schemeId organizationId ID.
     * @param int $uploadId organization Image Type
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUploadImage($organizationId, $organizationImageType)
    {
        try {

            DB::beginTransaction();

            $organizations = OrganizationModel::find($organizationId);

            $inputs = [];

            if($organizationImageType == 'banner'){
                $this->upload->deleteUpload($organizations->banner);
                $inputs['banner'] = null;
            }

            if($organizationImageType == 'logo'){
                $this->upload->deleteUpload($organizations->logo);
                $inputs['logo'] = null;
            }

            
            $result = $organizations->update($inputs);

            if ($result) {
                DB::commit();

                return response()->json(array(
                    'error' => 0,
                    'message' => __('File Deleted Successfully!')
                ));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json(array(
                'error' => 1,
                'message' => $e->getMessage()
            ));
        }
    }


    
}
