<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\Division;
use App\Models\Settings\FarmerModel;
use App\Http\Requests\FarmerRequest;
use Auth;
use Session;
use DB;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        $itemsPerPage = itemsPerPage();
        $_args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        $_args = filterParams(
            $_args,
            array(
                'division_id',
                'district_id',
                'upazila_id',
                'union_id'
            )
        );


        $data['farmersLists'] = FarmerModel::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;
        $data['divisions'] = Division::getDivisionListArray();
       
        
        return view('settings.farmer.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data =[];
        $data = array_merge($data,$this->generalConfigData());

        return view('settings.farmer.create', $data);
    }


/**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FarmerRequest $request)
    {
         try {
            $requestData = $this->pushUserSessionData( $request->all() );
          
            $requestData['division_region_id']  =  $requestData['division_id'];
            $requestData['created_by'] = Auth::id();
            $insertResult = FarmerModel::create($requestData);

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Settings\FarmerController@create'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $data = [];
        $demonstrationsInfo = FarmerModel::getAll([], $id)[0];
      
        return view('settings.farmer.show', compact('demonstrationsInfo'))->with( $data );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {

        $data =[];
        $data = array_merge($data,$this->generalConfigData());
        $farmerInfo     = FarmerModel::findOrFail($id);

        return view('settings.farmer.edit', compact('farmerInfo'))->with( $data );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(FarmerRequest $request, $id)
    {

        try {
            $requestData = $this->pushUserSessionData( $request->all() );
            
            $demonstrations = FarmerModel::findOrFail($id);
            $requestData['division_region_id']  =  $requestData['division_id'];
            $requestData['updated_by'] = Auth::id();
            $demonstrations->update($requestData);

            Session::flash('success', __('Updated Successfully!'));
            return back();

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            FarmerModel::destroy($id);

            DB::commit();

            return redirect()->back()->with('success', __('Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }


     /**
     * Get Common Form Setup Data
     * @return array
     *
     */

    public function generalConfigData($id = null){
       
        $data = array();
        $commonLabelsModel          = new CommonLabel;
        $data['ethnicCommunity']    = CommonLabel::getCLWithKeyValue('ethnic-community');
        $data['genderList']         = genders();
        return $data;
    }

    public function addNewFarmer(Request $request)
    {

        try {
            $requestData                 = $request->all();
            $requestData['created_by']   = Auth::id();
            $requestData['division_region_id']   = $requestData['division_id'];
            $insertResult               = FarmerModel::create($requestData);

            $lang = config('app.locale');
            $name = "name_{$lang}";

            $insertResult->name = $insertResult->$name;

            $data = ['data'=>$insertResult, 'error' => 0, 'message' => 'New Farmer Information created successfully.'];
        } catch (\Exception $e) {

            $data = ['error' => 1, 'message' => $e->getMessage()];
        }

        return response()->json($data);
    }

    public function getFarmerById($farmerId)
    {
        try {
            
            $insertResult  = FarmerModel::find($farmerId);

            $lang = config('app.locale');
            $name = "name_{$lang}";

            $insertResult->name = $insertResult->$name;

            $data = ['data'=>$insertResult, 'error' => 0, 'message' => 'Success.'];
        } catch (\Exception $e) {

            $data = ['error' => 1, 'message' => $e->getMessage()];
        }

        return response()->json($data);
    }
}
