<?php

namespace App\Http\Controllers\Settings;


use DB;
use Session;
use Validator;
use Illuminate\Http\Request;
use App\Models\Settings\Region;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\RegionRequest;

/**
 * Division Controller Class .
 * php version > = 7.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://gitlab.com/technovistaltd/laravel-base-framework
 */

class RegionController extends Controller
{
    
    /**
     * Display the list of Division
     *
     * @return array()
     *
     */
    public function index()
    {
        $data = [];

        $itemsPerPage = itemsPerPage();

        $regionModel = new Region();
        $data['RegionModel'] = $regionModel;


        $args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        // Push Filter/Search Parameters.
        $args = filterParams(
            $args,
            array(
                'name'      => 'name',
                'geo_code'  => 'geo_code',
                'is_active' => 'is_active',
            )
        );

        $data['regions'] = $regionModel->getRegions($args);

        return view('settings/region.list', compact('itemsPerPage'))->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('settings/region.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function save(RegionRequest $request)
    {
        try {
            $inputs = $request->all();

            $inputs['created_by'] = Auth::id();
            $inputs['is_active']  = (int) $inputs['is_active'];

            // Starting database transaction
            DB::beginTransaction();

            $regions = Region::create($inputs);

            DB::commit();


            Session::flash('success', 'Saved Successfully!');

            // Redirect to edit mode.
            return redirect(action('Settings\RegionController@edit', ['region_id' => $regions->id]));
            
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
     * @param integer $region_id Region ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($region_id)
    {
        $regions = Region::findOrFail($region_id);
        
        return view('settings/region.edit', compact('regions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RegionRequest $request)
    {
        try {
            $inputs = $request->all();

            $inputs['updated_by'] = Auth::id();
            $inputs['is_active']  = (int) $inputs['is_active'];

            // Starting database transaction
            DB::beginTransaction();

            $regionInfo = Region::findorfail($inputs['id']);
            $regionInfo->update($inputs);
            // Commit all transaction
            DB::commit();

            Session::flash('success', 'Updated Successfully!');

            return redirect()->back();
            
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
     * @param integer $region_id Regions ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($region_id)
    {
        // $district = DB::table('districts')
        //     ->where('region_id', $region_id)
        //     ->pluck('id')
        //     ->first();

        // if (!empty($district)) {
        //     return redirect()->back()->withErrors(__('Sorry, The Division has a District that is not deleted yet!'));
        // }

        $region = Region::where('id', $region_id)->first();
      
        if ($region != null) {
           
            $region->delete();

            Session::flash('success', __('Deleted Successfully!'));

            // Redirect to list page.
            return redirect(action('Settings\RegionController@index'));
        } else {
            return redirect()->back()->withErrors(__('Sorry, Please Try Again!'));
        }
    }


}
