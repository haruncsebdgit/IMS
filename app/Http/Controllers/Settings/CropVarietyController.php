<?php

namespace App\Http\Controllers\Settings;

use Auth;
use Session;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\CropVariety;

class CropVarietyController extends Controller
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
                'crop_id',
                'crop_type_id'
            )
        );


        $data = CropVariety::getCommonConfigData();
        $data['cropvariety'] = CropVariety::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('settings.crop-variety.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = CropVariety::getCommonConfigData();
        return view('settings.crop-variety.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
         try {
            $this->validate($request, [
			'crop_id' => 'required',
			'name_en' => 'required',
			'name_bn' => 'required'
		]);
            
            CropVariety::saveOrUpdate($this->pushUserSessionData( $request->all() ));

            Session::flash('success', __('Saved Successfully!'));

            // Redirect to edit mode.
            return redirect(action('Settings\CropVarietyController@create'));
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
        $cropvariety = CropVariety::findOrFail($id);

        return view('settings.crop-variety.show', compact('cropvariety'));
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
        $data = CropVariety::getCommonConfigData();
        $data['cropvariety'] = CropVariety::findOrFail($id);

        return view('settings.crop-variety.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        try {

            $this->validate($request, [
			'crop_id' => 'required',
			'name_en' => 'required',
			'name_bn' => 'required'
		]);
            
            CropVariety::saveOrUpdate($this->pushUserSessionData( $request->all(), false ), $id);

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
            CropVariety::destroy($id);

            return redirect()->back()->with('success', __('Deleted Successfully!'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function getUnitByCropItemId($cropItemId)
    {
        return response()->json(CropVariety::whereCropId($cropItemId)->value('unit_id'));
    }
}
