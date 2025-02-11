<?php
namespace App\Http\Controllers\Settings;

use DB;
use Session;
use Illuminate\Http\Request;
use App\Models\Settings\Division;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\DivisionRequest;

/**
 * Division Controller Class .
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://gitlab.com/technovistaltd/laravel-base-framework
 */
class DivisionController extends Controller
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

        $divisionModel = new Division();
        $data['DivisionModel'] = $divisionModel;


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

        $data['divisions'] = $divisionModel->getDivisions($args);

        return view('settings/division.list', compact('itemsPerPage'))->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('settings/division.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function save(DivisionRequest $request)
    {
        try {
            $inputs = $request->all();

            $inputs['created_by'] = Auth::id();
            $inputs['is_active']  = (int) $inputs['is_active'];

                // Starting database transaction
                DB::beginTransaction();

                $division = Division::create($inputs);

                DB::commit();

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("division_front_{$division->id}");

                Session::flash('success', 'Saved Successfully!');

                // Redirect to edit mode.
                return redirect(action('Settings\DivisionController@edit', ['division_id' => $division->id]));
        
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
     * @param integer $division_id Division ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($division_id)
    {
        $division = Division::findOrFail($division_id);

        return view('settings/division.edit', compact('division'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(DivisionRequest $request)
    {
        try {
            $inputs = $request->all();

            $inputs['updated_by'] = Auth::id();
            $inputs['is_active']  = (int) $inputs['is_active'];

                // Starting database transaction
                DB::beginTransaction();

                $divisionInfo = Division::findorfail($inputs['id']);
                $divisionInfo->update($inputs);

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("division_front_{$divisionInfo->id}");

                if (0 == $divisionInfo->is_active) {
                    DB::table('union_wards')
                        ->leftJoin('thana_upazilas', 'thana_upazilas.id', 'union_wards.thana_upazila_id')
                        ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                        ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
                        ->where('divisions.id', $divisionInfo->id)
                        ->update(['union_wards.is_active' => 0]);

                    DB::table('thana_upazilas')
                        ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                        ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
                        ->where('divisions.id', $divisionInfo->id)
                        ->update(['thana_upazilas.is_active' => 0]);

                    DB::table('districts')
                        ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
                        ->where('divisions.id', $divisionInfo->id)
                        ->update(['districts.is_active' => 0]);
                } else {
                    DB::table('union_wards')
                        ->leftJoin('thana_upazilas', 'thana_upazilas.id', 'union_wards.thana_upazila_id')
                        ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                        ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
                        ->where('divisions.id', $divisionInfo->id)
                        ->update(['union_wards.is_active' => 1]);

                    DB::table('thana_upazilas')
                        ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                        ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
                        ->where('divisions.id', $divisionInfo->id)
                        ->update(['thana_upazilas.is_active' => 1]);

                    DB::table('districts')
                        ->leftJoin('divisions', 'divisions.id', '=', 'districts.division_id')
                        ->where('divisions.id', $divisionInfo->id)
                        ->update(['districts.is_active' => 1]);
                }

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
     * @param integer $division_id Division ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($division_id)
    {
        $district = DB::table('districts')
            ->where('division_id', $division_id)
            ->pluck('id')
            ->first();

        if (!empty($district)) {
            return redirect()->back()->withErrors(__('Sorry, The Division has a District that is not deleted yet!'));
        }

        $division = Division::where('id', $division_id)->first();

        if ($division != null) {
            $division->delete();

            // CACHE: Clear the FrontEnd Dashboard usage.
            Cache::forget("division_front_{$division_id}");

            Session::flash('success', __('Deleted Successfully!'));

            // Redirect to list page.
            return redirect(action('Settings\DivisionController@index'));
        } else {
            return redirect()->back()->withErrors(__('Sorry, Please Try Again!'));
        }
    }

}
