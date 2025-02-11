<?php

namespace App\View\Components;

use App\Models\Project;
use App\Models\Settings\OrganizationModel;
use App\Models\Settings\Organogram;
use Illuminate\View\Component;
use Auth;

class Office extends Component
{
    public $cols = 4;   // Column in rows. Ex. col-sm-{$cols}
    public $isShowOrganization = true;
    public $isShowOrganogram = true;
    public $isShowProject = true;

    public $isRequiredOrganization = "";
    public $isRequiredOrganogram = "";
    public $isRequiredProject = "";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $required = [],
        $cols = 4
    ){
        $this->cols = $cols;
        $this->checkRequiredField ($required);
    }

    public function checkRequiredField($required)
    {
        if(isset($required['organization']) && $required['organization'] == 1) {
            $this->isRequiredOrganization = 'required';
        }
        if(isset($required['organogram']) && $required['organogram'] == 1) {
            $this->isRequiredOrganogram = 'required';
        }
        if(isset($required['project']) && $required['project'] == 1) {
            $this->isRequiredProject = 'required';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $data['organizations'] = OrganizationModel::getOrganizationList();
        $data['isRequiredOrganization'] = $this->isRequiredOrganization;
        $data['isRequiredOrganogram'] = $this->isRequiredOrganogram;
        $data['isRequiredProject'] = $this->isRequiredProject;

        $data['cols'] = $this->cols;
        $data['organograms'] = (new Organogram())->organogramDropdown();
        $data['projects'] = Project::getProjectList();
        // dd($data['organograms']);
        return view('components.office', $data);
    }
}
