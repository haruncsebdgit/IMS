<?php
namespace App\Http\Controllers\Settings;

use DB;
use Session;
use Response;
use Validator;
use Illuminate\Http\Request;
use App\Models\Settings\District;
use App\Http\Controllers\Controller;
use App\Models\Settings\ThanaUpazila;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Thana Upazilas Controller Class .
 * php version 7.1.3
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://gitlab.com/technovistaltd/laravel-base-framework
 */

class ThanaUpazilaController extends Controller
{
    /**
     * Display the list of Thana Upazilas
     *
     * @return array
     */
    public function index()
    {
        $data = [];

        $itemsPerPage = itemsPerPage();

        $thanaUpazilaModel         = new ThanaUpazila();
        $data['thanaUpazilaModel'] = $thanaUpazilaModel;

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
                'district_id' => 'district_id',
            )
        );

        $data['thanaUpazilas'] = $thanaUpazilaModel->getThanaUpazilas($args);

        $districtModel     = new District();
        $data['districts'] = $districtModel->getDistrictList();

        return view('settings/thanaupazila.list', compact('itemsPerPage'))->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $districtModel = new District();
        $districts     = $districtModel->getDistrictList();

        return view('settings/thanaupazila.add', compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['created_by'] = Auth::id();
            $inputs['is_active']  = (int)$inputs['is_active'];

            // Validate.
            //$rules = $this->validateRules();

            //$validator = Validator::make($inputs, $rules);

            /* if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else { */
                // Starting database transaction.
                DB::beginTransaction();

                $thanaUpazila = ThanaUpazila::create($inputs);

                DB::commit();

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("upazila_front_{$thanaUpazila->id}");

                Session::flash('success', 'Saved Successfully!');

                // Redirect to edit mode.
                return redirect(action('Settings\ThanaUpazilaController@edit', ['thanaupazilas_id' => $thanaUpazila->id]));
            // }
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred.
            DB::rollBack();

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer $thana_upazila_id Thana Upazila ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($thana_upazila_id)
    {
        $districtModel = new District();
        $districts     = $districtModel->getDistrictList();

        $thanaUpazila = ThanaUpazila::findOrFail($thana_upazila_id);

        return view('settings/thanaupazila.edit', compact('districts', 'thanaUpazila'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['updated_by'] = Auth::id();
            $inputs['is_active']  = (int)$inputs['is_active'];

            // Validate.
            /* $rules = $this->validateRules($inputs['id']);

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else { */
                // Starting database transaction.
                DB::beginTransaction();

                $thanaUpazilaInfo = ThanaUpazila::findorfail($inputs['id']);
                $thanaUpazilaInfo->update($inputs);

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("upazila_front_{$thanaUpazilaInfo->id}");

                if (0 == $thanaUpazilaInfo->is_active) {
                    DB::table('union_wards')
                        ->leftJoin('thana_upazilas', 'thana_upazilas.id', 'union_wards.thana_upazila_id')
                        ->where('thana_upazilas.id', $thanaUpazilaInfo->id)
                        ->update(['union_wards.is_active' => 0]);
                } else {
                    DB::table('union_wards')
                        ->leftJoin('thana_upazilas', 'thana_upazilas.id', 'union_wards.thana_upazila_id')
                        ->where('thana_upazilas.id', $thanaUpazilaInfo->id)
                        ->update(['union_wards.is_active' => 1]);
                }

                // Commit all transaction.
                DB::commit();

                Session::flash('success', 'Updated Successfully!');

                return redirect()->back();
            // }
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
     * @param int $thana_upazila_id Thana Upazila ID.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($thana_upazila_id)
    {
        $unionWard = DB::table('union_wards')->where('thana_upazila_id', '=', $thana_upazila_id)->pluck('id')->first();

        if (empty($unionWard)) {
            $thanaUpazila = ThanaUpazila::where('id', $thana_upazila_id)->first();

            if ($thanaUpazila != null) {
                $thanaUpazila->delete();

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("upazila_front_{$thana_upazila_id}");

                Session::flash('success', __('Deleted Successfully!'));

                // Redirect to list page.
                return redirect(action('Settings\ThanaUpazilaController@index'));
            } else {
                return redirect()->back()->withErrors(__('Sorry, Please Try Again!'));
            }
        } else {
            return redirect()->back()->withErrors(__("Sorry, Upazila has an Union/Ward that's is not deleted yet!"));
        }
    }


    /**
     * Validation Rules.
     *
     * @param integer $thana_upazila_id Thana Upazila ID on Edit mode.
     *
     * @access private
     *
     * @return array
     */
    private function validateRules($thana_upazila_id = null)
    {
        return array(
            'name_en'     => 'required|max:255|unique_with:thana_upazilas,district_id,name_en,'.$thana_upazila_id,
            'name_bn'     => 'required|max:255',
            'geo_code'    => 'required|numeric',
            'district_id' => 'required|numeric'
        );
    }

    /**
     * Get Thana Upazila list by $district_id District ID
     *
     * @param $district_id District ID.
     *
     * @return mixed
     */
    public function getThanaUpazila($district_id = null)
    {
        if (empty($district_id)) {
            return;
        }

        $thanaUpazilaModel = new ThanaUpazila();
        $thanaUpazilas     = $thanaUpazilaModel->getListByDistrictId($district_id);

        return Response::json($thanaUpazilas);
    }
}
