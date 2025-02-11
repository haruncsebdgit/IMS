<?php
namespace App\Http\Controllers\Settings;

use DB;
use Session;
use Response;

use Validator;
use Illuminate\Http\Request;

use App\Models\Settings\UnionWard;
use App\Http\Controllers\Controller;

use App\Models\Settings\ThanaUpazila;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Union/Ward Controller Class .
 * php version 7.2.30
 *
 * @category Application
 * @package  LGSP3
 * @author   Ariful Islam Srabon <arif.cse18604@gmail.com>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class UnionWardController extends Controller
{
    /**
     * Validation Rules.
     *
     * @param integer $union_ward_id Union/Ward ID on Edit mode.
     *
     * @access private
     *
     * @return array
     * --------------------------------------------------------------------------
     */
    private function validateRules($union_ward_id = null)
    {
        return array(
            'name_en'          => 'required|max:255|unique_with:union_wards,thana_upazila_id,name_en,' . $union_ward_id,
            'name_bn'          => 'required|max:255|unique_with:union_wards,thana_upazila_id,name_bn,' . $union_ward_id,
            'geo_code'         => 'required|numeric',
            'type'             => 'required',
            'thana_upazila_id' => 'required|numeric'
        );
    }

    /**
     * Display the list of Union/Ward
     *
     * @return array()
     */
    public function index()
    {
        if (hasUserCap(['view_union_ward', 'add_union_ward'])) {
            $data         = [];
            $itemsPerPage = itemsPerPage();

            $unionWardModel         = new UnionWard();
            $data['unionWardModel'] = $unionWardModel;

            $args = array(
                'items_per_page' => $itemsPerPage,
                'paginate'       => true
            );

            // Push Filter/Search Parameters.
            $args = filterParams(
                $args,
                array(
                    'name'             => 'name',
                    'geo_code'         => 'geo_code',
                    'is_active'        => 'is_active',
                    'thana_upazila_id' => 'thana_upazila_id',
                )
            );

            $data['unionWardLists'] = $unionWardModel->getUnionWardLists($args);

            $thanaUpazilaModel     = new ThanaUpazila();
            $data['thanaUpazilas'] = $thanaUpazilaModel->getThanaUpazilas();

            return view('settings/unionward.list', compact('itemsPerPage'))->with($data);
        } else {
            return abort(403, 'Unauthorized Action');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * -----------------------------------------
     */
    public function add()
    {
        if (!hasUserCap('add_union_ward')) {
            return abort(401);
        }

        $thanaUpazilaModel = new ThanaUpazila();
        $thanaUpazilas = $thanaUpazilaModel->getThanaUpazilas();

        return view('settings/unionward.add', compact('thanaUpazilas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * -------------------------------------------
     */
    public function save(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['created_by'] = Auth::id();
            $inputs['is_active'] = (int)$inputs['is_active'];

            // validate
            /* $rules = $this->validateRules();

            $rules_msg = [
                'name_en.unique_with' => __('The Combination of Upazila and Name (English) already exists.'),
                'name_bn.unique_with' => __('The Combination of Upazila and Name (Bengali) already exists.'),
            ];

            $validator = Validator::make($inputs, $rules, $rules_msg);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else { */
                // Starting database transaction
                DB::beginTransaction();

                $union = UnionWard::create($inputs);

                // Commit all transaction
                DB::commit();

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("union_front_{$union->id}");

                Session::flash('success', 'Saved Successfully!');

                // Redirect to add mode.
                return redirect()->back();
            // }
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred
            DB::rollBack();

            return redirect()->back()
                ->withErrors('dangerMsg', $e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $union_ward_id Union/Ward ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function edit($union_ward_id)
    {
        if (!hasUserCap('edit_union_ward')) {
            return abort(401);
        }

        $thanaUpazilaModel = new ThanaUpazila();
        $thanaUpazilas = $thanaUpazilaModel->getThanaUpazilas();

        $unionWardInfo = UnionWard::findOrFail($union_ward_id);

        return view('settings/unionward.edit', compact('thanaUpazilas', 'unionWardInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();

            $inputs['updated_by'] = Auth::id();
            $inputs['is_active'] = (int)$inputs['is_active'];

            // validate
            //$rules = $this->validateRules($inputs['id']);

            /* $rules_msg = [
                'name_en.unique_with' => __('The Combination of Upazila and Name (English) already exists.'),
                'name_bn.unique_with' => __('The Combination of Upazila and Name (Bengali) already exists.'),
            ]; */

            //$validator = Validator::make($inputs, $rules, $rules_msg);

            /* if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else { */
                // Starting database transaction
                DB::beginTransaction();

                $unionWardInfo = UnionWard::findorfail($inputs['id']);
                $unionWardInfo->update($inputs);

                // Commit all transaction
                DB::commit();

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("union_front_{$unionWardInfo->id}");

                Session::flash('success', 'Updated Successfully!');

                // Redirect to edit mode.
                return redirect()->back();
            // }
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred
            DB::rollBack();

            return redirect()->back()
                ->withErrors('dangerMsg', $e->getMessage())
                ->withInput($request->all);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $union_ward_id Union/Ward ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------------------------------
     */
    public function delete($union_ward_id)
    {
        if (!hasUserCap('delete_union_ward')) {
            return abort(401);
        }

        $unionWard = UnionWard::where('id', $union_ward_id)->first();

        if ($unionWard != null) {
            $unionWard->delete();

            // CACHE: Clear the FrontEnd Dashboard usage.
            Cache::forget("union_front_{$union_ward_id}");

            Session::flash('success', __('Deleted Successfully!'));

            // Redirect to list page.
            return redirect(action('Settings\UnionWardController@index'));
        } else {
            return redirect()->back()->withErrors(__('Sorry, Please Try Again!'));
        }
    }

    /**
     * Get Union/Ward list by $thana_upazila_id Upazila ID
     *
     * @param $thana_upazila_id Upazila ID
     *
     * @return mixed
     * --------------------------------------------------------------------------
     */
    public function getUnionWard($thana_upazila_id = null)
    {
        if (empty($thana_upazila_id)) {
            return;
        }

        $unionWardModel = new UnionWard();
        $unionWards = $unionWardModel->getListByUnionWardId($thana_upazila_id);
        return Response::json($unionWards);
    }
}
