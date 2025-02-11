<?php

namespace App\Http\Controllers\Settings;

use DB;
use Session;

use Validator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Settings\FinancialYear;
use Illuminate\Support\Facades\Input;

/**
 * Financial Year Controller Class.
 *
 * @category Application
 * @package  LGSP3
 * @author   Mayeenul Islam <wz.islam@gmail.com>
 * @author   Mowshana Farhana <mowshana.farhana@technovista.com.bd>
 * @license  MIT (https://opensource.org/licenses/MIT)
 * @link     https://technovista.com.bd/solution/vista-cms/
 */
class FinancialYearController extends Controller
{
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
            'year_name'  => 'required|max:255',
            'start_date' => 'required',
            'end_date'   => 'required',
        );
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (hasUserCap(['view_financial_year', 'add_financial_year'])) {
            $itemsPerPage = itemsPerPage();

            $financialYearModel         = new FinancialYear;
            $data['financialYearModel'] = $financialYearModel;

            $args = array(
                'items_per_page' => $itemsPerPage,
                'paginate'       => true
            );

            $data['financialYears'] = $financialYearModel->getFinancialYear($args);

            return view('settings.financial-year.list', compact('itemsPerPage'))->with($data);
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
        if (!hasUserCap('add_financial_year')) {
            return abort(401);
        }

        $data                       = array();
        $financialYearModel         = new FinancialYear;
        $data['financialYearModel'] = $financialYearModel;

        return view('settings.financial-year.add')->with($data);
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

            $inputs['start_date'] = $this->dateFormat($inputs['start_date']);
            $inputs['end_date']   = $this->dateFormat($inputs['end_date']);

            $sort_order           = !empty($request->sort_order) ? $request->sort_order : 0;
            $inputs['sort_order'] = intval($sort_order);

            $inputs['created_by'] = Auth::id();

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

                $resultValue = $this->checkDateRangeOverlapping($inputs);

                if (!empty($resultValue)) {
                    return redirect(action('Settings\FinancialYearController@add'));
                }

                $financialYear = FinancialYear::create($inputs);

                // Only One Financial Year will be Active, Others Financial Year will be Inactive.
                if(isset($inputs['is_current_fy']) && $inputs['is_current_fy'] == 1){
                    DB::table('financial_years')->where('id', '<>', $financialYear->id)->update(['is_current_fy' => 0]);
                    DB::table('financial_years')->where('id', '=', $financialYear->id)->update(['is_active' => 1]);
                }elseif(!isset($inputs['is_current_fy'])){
                    $isCurrentFy = DB::table('financial_years')->where('is_current_fy', '=', 1)->value('id');

                    $today = date('Y-m-d');

                    if($isCurrentFy == null){
                        $currentYear = DB::table('financial_years')
                        ->whereRaw("'$today' between start_date and end_date")
                        ->first();

                        if($currentYear){
                            DB::table('financial_years')->where('id', '=', $currentYear->id)->update(['is_current_fy' => 1, 'is_active' => 1]);
                        }
                    }
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
     * @param int $financial_year_id Financial Year ID
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($financial_year_id)
    {
        if (!hasUserCap('edit_financial_year')) {
            return abort(401);
        }

        $the_financial_year = FinancialYear::findOrFail($financial_year_id);

        $financialYearModel         = new FinancialYear;
        $data['financialYearModel'] = $financialYearModel;

        return view('settings.financial-year.edit', compact('the_financial_year'))->with($data);
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

            $inputs['start_date'] = $this->dateFormat($inputs['start_date']);
            $inputs['end_date']   = $this->dateFormat($inputs['end_date']);

            $sort_order           = !empty(Request::input('sort_order')) ? Request::input('sort_order') : 0;
            $inputs['sort_order'] = intval($sort_order);

            if (!isset($inputs['is_current_fy'])) {
                $inputs['is_current_fy'] = 0;
            }

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

                $financialYearValue = FinancialYear::findorfail($inputs['id']);

                $resultValue = $this->checkDateRangeOverlapping($inputs);

                if (!empty($resultValue)) {
                    return redirect(action('Settings\FinancialYearController@edit', array('financial_year_id' => $inputs['id'])));
                }

                $financialYearValue->update($inputs);

                // Only One Financial Year will be Active, Others Financial Year will be Inactive.
                if(isset($inputs['is_current_fy']) && $inputs['is_current_fy'] == 1){
                    DB::table('financial_years')->where('id', '<>' , $inputs['id'])->update(['is_current_fy' => 0]);
                    DB::table('financial_years')->where('id', '=' , $inputs['id'])->update(['is_active' => 1]);
                }elseif(empty($inputs['is_current_fy']) && $inputs['is_current_fy'] == 0){
                    $isCurrentFy = DB::table('financial_years')->where('is_current_fy', '=', 1)->value('id');

                    $today = date('Y-m-d');

                    if($isCurrentFy == null){
                        $currentYear = DB::table('financial_years')
                        ->whereRaw("'$today' between start_date and end_date")
                        ->first();

                        if($currentYear){
                            DB::table('financial_years')->where('id', '=', $currentYear->id)->update(['is_current_fy' => 1, 'is_active' => 1]);
                        }
                    }
                }

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
     * @param int $financial_year_id Financial Year ID
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($financial_year_id)
    {
        if (!hasUserCap('delete_financial_year')) {
            return abort(401);
        }

        $financialYear = FinancialYear::where('id', $financial_year_id)->first();

        if ($financialYear != null) {
            $financialYear->delete();

            Session::flash('success', __('Deleted Successfully!'));

            return redirect()->back();
        } else {
            return redirect()->back()->withErrors('dangerMsg', __('Sorry, Please Try Again!'));
        }
    }

    /**
     * Checking Financial year Date Between Start Date & End Date
     *
     * @param $inputs
     *
     * @return $result result
     */
    public function checkDateRangeOverlapping($inputs)
    {
        if (!empty($inputs['start_date'])) {
            $dateStart = date('Y-m-d', strtotime($inputs['start_date']));
        }

        if (!empty($inputs['end_date'])) {
            $dateTo = date('Y-m-d', strtotime($inputs['end_date']));
        }

        $financialYearId = $inputs['id'];

        if (empty($financialYearId)) {
            $sql = "SELECT * FROM financial_years WHERE
                    (start_date BETWEEN '{$dateStart}' AND '{$dateTo}' OR
                    end_date BETWEEN '{$dateStart}' AND '{$dateTo}' OR
                    '{$dateStart}' BETWEEN start_date AND end_date)";
        } else {
            $sql = "SELECT * FROM financial_years WHERE
                    (start_date BETWEEN '{$dateStart}' AND '{$dateTo}' OR
                    end_date BETWEEN '{$dateStart}' AND '{$dateTo}' OR
                    '{$dateStart}' BETWEEN start_date AND end_date)
                    AND $financialYearId != id";
        }

        $result = DB::select($sql);

        return $result;
    }
}
