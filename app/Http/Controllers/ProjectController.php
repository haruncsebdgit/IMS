<?php

namespace App\Http\Controllers;

use App\Helpers\Reports;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\ProjectCostCenter;
use App\Models\ProjectFundsource;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\Organogram;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use Illuminate\Database\Eloquent\Builder;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $itemsPerPage = itemsPerPage();
        $_args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );
        $_args = filterParams(
            $_args,
            array(
                'project_id',
                'project_name'
            )
        );

        $data['projects'] = Project::getAll($_args);
        $data['itemsPerPage'] = $itemsPerPage;

        return view('projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['fundSources'] = CommonLabel::getCLWithKeyValue('fund-source');
        return view('projects.create', $data);
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
                'project_id_en' => 'required',
                'project_id_bn' => 'required',
                'project_name_en' => 'required',
                'project_name_bn' => 'required'
            ]);
            $requestData = $request->all();
            //dd($requestData);
            //dd($requestData['created_by']);
            DB::beginTransaction();
            
            Project::saveOrUpdateProject($requestData);

            DB::commit();
            //Project::create($requestData);
    
            Session::flash('success', __('Saved Successfully!'));
            return redirect(action('ProjectController@create'));

        } catch (\Exception $e) {
            DB::rollBack();
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
    public function show($id, $mode = null)
    {
        $lang = config('app.locale');
        $name = "project_name_{$lang}";
        $data['fundSources'] = CommonLabel::getCLWithKeyValue('fund-source');
        $data['project'] = $project = Project::findOrFail($id);
        $data['projectFundSources'] = $project->fundSources()->get();
        $data['organograms'] = Organogram::getOrganogramLists();
        $data['costCenters'] = $project->costCenters()->get();
        $data['projectLists'] = Project::pluck($name, 'id');

        if(!empty($mode) && $mode == 'print') {
            $data['filename'] = 'project-preview';
            Reports::showMaster('projects.view', ['mode' => 'print'], $data);
        } else {
            return view('projects.show', $data);
        }

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
        $data['fundSources'] = CommonLabel::getCLWithKeyValue('fund-source');
        $data['project'] = $project = Project::findOrFail($id);
        $data['projectFundSources'] = $project->fundSources()->get();
        $lang = config('app.locale');
        $name = "project_name_{$lang}";
        $data['organograms'] = Organogram::getOrganogramLists();
        $data['costCenters'] = $project->costCenters()->get();
        $data['projectLists'] = Project::pluck($name, 'id');

        return view('projects.edit', $data);
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
                'project_id_en' => 'required',
                'project_id_bn' => 'required',
                'project_name_en' => 'required',
                'project_name_bn' => 'required'
            ]);
            $requestData = $request->all();

            DB::beginTransaction();
            Project::saveOrUpdateProject($requestData, $id);
            DB::commit();

            Session::flash('success', __('Updated Successfully!'));
            return back();

        } catch (\Exception $e) {
            DB::rollBack();
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

            ProjectFundsource::where('project_id', $id)->delete();
            ProjectCostCenter::where('project_id', $id)->delete();
            Project::destroy($id);

            DB::commit();

            return redirect()->back()->with('success', __('Deleted Successfully!'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
        
    }

    public function getOriginProjectByPhaseNo($phaseNo) 
    {
        return Project::whereHas('costCenters', function (Builder $query) use ($phaseNo) {
            $query->where('phase_no', $phaseNo);
        })->get();
    }

    public function getProjectsBySearchParam (Request $request)
    {
        return Project::getProjects($request->all());
    }
}
