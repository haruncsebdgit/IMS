<?php

/**
 * Common Label Controller.
 * php version 7.1.3
 *
 * @category Application
 * @license  MIT (https://opensource.org/licenses/MIT)
 */

namespace App\Http\Controllers\Settings;

use DB;
use Cache;
use Session;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\OrganizationModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\CommonLabelsRequest;

/**
 * Common Label Controller.
 * php version 7.1.3
 *
 * @category Application
 */
class CommonLabelController extends Controller
{
    /**
     * Get Data Types.
     *
     * @return array
     * --------------------------------------------------
     */
    public static function getDataTypes()
    {
        return [
            'education-degrees'           => __('Degree'),
            'designations'                => __('Designations'),
            'units'                       => __('Unit'),
            'asset-location'              => __('Asset Location'),
            'manufacturer'                => __('Manufacturer'),
            'employee-type'               => __('Employee Type'),
            'employee-category'           => __('Employee Category'),
            'employee-class'              => __('Employee Class'),

        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param string $data_type Current Data Type of Common Labels
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function index($data_type = '')
    {
        $itemsPerPage = itemsPerPage();
        $lang         = config('app.locale');

        $data['currentDataType'] = $data_type ?? '';

        $commonLabelModel         = new CommonLabel;
        $data['commonLabelModel'] = $commonLabelModel;

        $userModel     = new User;
        $data['users'] = $userModel->getUsers(
            [
                'order' => array("users.name_{$lang}" => 'asc')
            ]
        );

        $args = array(
            'data_type'      => $data_type,
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        // Push Filter/Search Parameters.
        $args = filterParams(
            $args,
            array(
                'search' => 'search',
                'author' => 'author'
            )
        );

        $data['dataTypes'] = $this->getDataTypes();

        $data['commonLabels'] = $commonLabelModel->getCommonLabels($args);


        return view('settings.common-labels.list', compact('itemsPerPage'))->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function save(CommonLabelsRequest $request)
    {
        try {
            $inputs = $request->all();

            $order           = !empty($inputs['order']) ? $inputs['order'] : 0;
            $inputs['order'] = intval($order);

            $inputs['created_by'] = Auth::id();


            // Starting database transaction
            DB::beginTransaction();

            CommonLabel::create($inputs);

            $cacheKey = 'common_label_' . $inputs['data_type'];

            // Clear the specific cache.
            Cache::flush();
            /* if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            } */

            // Commit all transaction
            DB::commit();

            Session::flash('success', 'Saved Successfully!');

            // Redirect to list page.
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
     * Show the form for editing the specified resource.
     *
     * @param int $common_label_id Common Label ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function edit($common_label_id)
    {
        $the_common_label = CommonLabel::findOrFail($common_label_id);

        $commonLabelModel         = new CommonLabel;
        $data['commonLabelModel'] = $commonLabelModel;

        $data['dataTypes'] = $this->getDataTypes();

        $data['commonLabels'] = $commonLabelModel->getCommonLabels(
            array(
                'exclude' => array($common_label_id)
            )
        );

        $organizationModel         = new OrganizationModel;
        $data['organizationLists'] = $organizationModel->getOrganizationList();

        return view('settings.common-labels.edit', compact('the_common_label'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function update(CommonLabelsRequest $request)
    {
        try {
            $inputs = $request->all();

            $order           = !empty($inputs['order']) ? $inputs['order'] : 0;
            $inputs['order'] = intval($order);

            $inputs['updated_by'] = Auth::id();


            // Starting database transaction
            DB::beginTransaction();

            $commonLabelValue = CommonLabel::findorfail($inputs['id']);
            $commonLabelValue->update($inputs);

            $cacheKey = 'common_label_' . $commonLabelValue->data_type;

            // Clear the specific cache.
            Cache::flush();
            /* if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            } */

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
     * @param int $common_label_id Common Label ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function delete($common_label_id)
    {
        $commonLabel = CommonLabel::find($common_label_id);
        $delete = $commonLabel->delete();

        if ($delete) {
            $cacheKey = 'common_label_' . $commonLabel->data_type;

            // Clear the specific cache.
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
            }
        }

        return redirect()->back()
            ->with('success', __('Deleted Successfully!'));
    }
}
