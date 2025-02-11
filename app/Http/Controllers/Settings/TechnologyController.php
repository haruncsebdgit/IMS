<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\TechnologyModel;
use Illuminate\Http\Request;
use App\Http\Requests\TechnologyRequest;
use App\Models\Settings\CommonLabel;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class TechnologyController extends Controller
{
    public function index(Request $request){
        $itemsPerPage = itemsPerPage();
        $_args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        $_args = filterParams(
            $_args,
            array(
                'name',
                'is_active',
                'technology_type_id',
            )
        );

        $data['technologyLists'] = TechnologyModel::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;
        $commonLabelsModel = new CommonLabel;
        $data['technologyTypeList'] = $commonLabelsModel->getCLWithKeyValue('technology-type');
        return view('settings.technology.list')->with($data);
    }

    public function add(){
        $data                       = array();
        $commonLabelsModel = new CommonLabel;
        $data['technologyTypeList'] = $commonLabelsModel->getCLWithKeyValue('technology-type');
        

        // return view('settings.organization.add')->with($data);
        return view('settings/technology.add')->with($data);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(TechnologyRequest $request)
    {
        try {
            $inputs = $this->pushUserSessionData( $request->all() );
            $inputs['created_by'] = Auth::id();
            $inputs['is_active']  = (int) $inputs['is_active'];
            $inputs['organization_id'] = auth()->user()->organization_id;

             //Starting database transaction
             DB::beginTransaction();

             $technology = TechnologyModel::create($inputs);

             DB::commit();
            //  Cache::forget("division_front_{$division->id}");

             Session::flash('success', 'Saved Successfully!');
            //  dd($technology->id);

             // Redirect to edit mode.
             return redirect(action('Settings\TechnologyController@add'));

            
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred
            DB::rollBack();

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    public function destroy($id){
        try {
            DB::beginTransaction();
            
            TechnologyModel::destroy($id);
            
            DB::commit();
            
            return redirect()->back()->with('success', __('Deleted Successfully!'));
            } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
            ->withErrors($e->getMessage())
            ->withInput();
            }
    }

    public function update(TechnologyRequest $request, $technology_id){
        try {
            $requestData = $this->pushUserSessionData( $request->all() );
            $technologies = TechnologyModel::findOrFail($technology_id);
            $requestData['is_active']  = (int) $requestData['is_active'];
            $requestData['organization_id'] = auth()->user()->organization_id;
            $requestData['updated_by'] = Auth::id();
            DB::beginTransaction();

            $technologies->update($requestData);
            
            DB::commit();
            
        
            
            Session::flash('success', __('Updated Successfully!'));
            return back();
            
            } catch (\Exception $e) {
            return redirect()->back()
            ->withErrors($e->getMessage())
            ->withInput($request->all);
            }
    }

    public function edit($technology_id){
        $technologyInfo = TechnologyModel::findOrFail($technology_id);
        $data                       = array();
        $commonLabelsModel = new CommonLabel;
        $data['technologyTypeList'] = $commonLabelsModel->getCLWithKeyValue('technology-type');

        // return view('settings.organization.add')->with($data);
        return view('settings/technology.edit',compact("technologyInfo"))->with($data);
    }
}
