<?php
namespace App\Http\Controllers\Settings;

use DB;
use Session;
use Response;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\DistrictRequest;
use App\Models\Settings\Region;

/**
 * District Controller Class .
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://gitlab.com/technovistaltd/laravel-base-framework
 */
class DistrictController extends Controller
{
    /**
     * Display the list of District
     *
     * @return array
     */
    public function index()
    {
        $data = [];

        $itemsPerPage = itemsPerPage();

        $districtModel = new District();
        $data['districtModel'] = $districtModel;

        $args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        // Push Filter/Search Parameters.
        $args = filterParams(
            $args,
            array(
                'name'        => 'name',
                'geo_code'    => 'geo_code',
                'is_active'   => 'is_active',
                'division_id' => 'division_id',
            )
        );

        $data['districts'] = $districtModel->getDistricts($args);

        $divisionsModel = new Division();
        $data['divisions'] = $divisionsModel->getDivisionList();

        return view('settings/district.list', compact('itemsPerPage'))->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $divisionsModel = new Division();

        $divisions = $divisionsModel->getDivisionList();

        $regionsModel = new Region();
        $regions = $regionsModel->getRegionList();

        return view('settings/district.add', compact('divisions','regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * -------------------------------------------
     */
    public function save(DistrictRequest $request)
    {
        try {
            $inputs = $request->all();

            $inputs['created_by'] = Auth::id();
            $inputs['is_active']  = (int) $inputs['is_active'];

            // Validate.
            //$rules = $this->validateRules();

            //$validator = Validator::make($inputs, $rules);

           /*  if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else { */
                // Starting database transaction
                DB::beginTransaction();

                $district = District::create($inputs);

                DB::commit();

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("district_front_{$district->id}");

                Session::flash('success', 'Saved Successfully!');

                // Redirect to edit mode.
                return redirect(action('Settings\DistrictController@edit', ['district_id' => $district->id]));
            // }
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
     * @param integer $district_id District ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($district_id)
    {
        $divisionsModel = new Division();

        $divisions = $divisionsModel->getDivisionList();
        $district  = District::findOrFail($district_id);

        $regionsModel = new Region();
        $regions = $regionsModel->getRegionList();

        return view('settings/district.edit', compact('divisions','regions','district'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictRequest $request)
    {
        try {
            $inputs = $request->all();

            $inputs['updated_by'] = Auth::id();
            $inputs['is_active']  = (int) $inputs['is_active'];

            // Starting database transaction.
            DB::beginTransaction();

            $district = District::findorfail($inputs['id']);
            $district->update($inputs);

            // CACHE: Clear the FrontEnd Dashboard usage.
            Cache::forget("district_front_{$district->id}");

            if (0 == $district->is_active) {
                DB::table('union_wards')
                    ->leftJoin('thana_upazilas', 'thana_upazilas.id', 'union_wards.thana_upazila_id')
                    ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                    ->where('districts.id', $district->id)
                    ->update(['union_wards.is_active' => 0]);

                DB::table('thana_upazilas')
                    ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                    ->where('districts.id', $district->id)
                    ->update(['thana_upazilas.is_active' => 0]);
            } else {
                DB::table('union_wards')
                    ->leftJoin('thana_upazilas', 'thana_upazilas.id', 'union_wards.thana_upazila_id')
                    ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                    ->where('districts.id', $district->id)
                    ->update(['union_wards.is_active' => 1]);

                DB::table('thana_upazilas')
                    ->leftJoin('districts', 'districts.id', '=', 'thana_upazilas.district_id')
                    ->where('districts.id', $district->id)
                    ->update(['thana_upazilas.is_active' => 1]);
            }

            // Commit all transactions.
            DB::commit();

            Session::flash('success', 'Updated Successfully!');

            return redirect()->back();
            
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred.
            DB::rollBack();

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $district_id District ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($district_id)
    {
        $thanaUpazila = DB::table('thana_upazilas')->where('district_id', '=', $district_id)->pluck('id')->first();

        if (!empty($thanaUpazila)) {
            return redirect()->back()->withErrors(__('Sorry, The District has a Upazila that is not deleted yet!'));
        }

        $district = District::where('id', $district_id)->first();

        if ($district != null) {
            $district->delete();

            // CACHE: Clear the FrontEnd Dashboard usage.
            Cache::forget("district_front_{$district_id}");

            Session::flash('success', __('Deleted Successfully!'));

            // Redirect to list page.
            return redirect(action('Settings\DistrictController@index'));
        } else {
            return redirect()->back()->withErrors(__('Sorry, Please Try Again!'));
        }
    }

  

    /**
     * Get District list by $division_id Division ID
     *
     * @param $division_id
     *
     * @return mixed
     */
    public function getDistrict($division_id = null)
    {
        if (empty($division_id)) {
            return;
        }

        $districtModel = new District();
        $districts     = $districtModel->getListByDivisionId($division_id);

        return Response::json($districts);
    }
}
