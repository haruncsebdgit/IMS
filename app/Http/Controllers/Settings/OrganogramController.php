<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganogramRequest;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\Organogram;
use App\Models\Settings\ThanaUpazila;
use App\Models\Settings\UnionWard;
use Session;

class OrganogramController extends Controller
{
    private $organogram;

    public function __construct(Organogram $organogram)
    {
        $this->organogram = $organogram;
    }

    public function index() 
    {
        $data = [];
        return view('settings.organogram.index', $data);
    }

    public function create($mode, $organogramId) 
    {
        $data = Organogram::getCommonMasterData($mode, $organogramId);
        
        if($mode === 'edit') {
            return view('settings.organogram.edit', $data);
        } else {
            return view('settings.organogram.create', $data);
        }
    }

    public function store(OrganogramRequest $request)
    {
        try {

            $this->organogram->saveOrUpdate($request->all());

            Session::flash('success', __('Saved Successfully!'));

            return redirect()->back();

        } catch (\Exception $e) {

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

    public function update(OrganogramRequest $request, $id)
    {
        try {

            $this->organogram->saveOrUpdate($request->all(), $id);

            Session::flash('success', __('Updated Successfully!'));

            return redirect()->back();

        } catch (\Exception $e) {

            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param int $user_id User ID.
     *
     * @return \Illuminate\Http\Response
     * --------------------------------------------------
     */
    public function delete($id)
    {
        try {
            $delete = Organogram::find($id)->delete();

            if ($delete == true) {
                Organogram::clearCache();
                return redirect()->back()->with('success', __('Deleted Successfully!'));
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(__("Sorry, can't deleted"))
                ->withInput();
        }
    }

    public function getOrganogramByOrganizationId($organizationId)
    {
        return response()->json((new Organogram())->organogramDropdown($organizationId));
    }
}
