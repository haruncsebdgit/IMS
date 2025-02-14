<?php

namespace App\View\Components;

use App\Models\Monitoring\Cig;
use App\Models\Monitoring\CigMember;
use App\Models\Settings\CommonLabel;
use App\Models\Settings\FarmerModel;
use Illuminate\View\Component;

/**
 * Farmer Component. 
 * Load Member Type (CIG/NON CIG) and show CIG Member or Farmer dropdown with member type wise
 * Added modal inside farmer dropdown button to add farmer from current scope.
 * 
 * @author Mohammad Harun-Or-Rashid
 */
class Farmer extends Component
{
    private $titleMemberType = 'Member Type';
    private $titleMemberName = 'Name of Member';
    private $isRequiredMemberType = 'required';
    private $isRequiredCig = 'required';
    private $isRequiredCigMember = 'required';
    private $isRequiredFarmer = 'required';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $titleMemberType = 'Member Type',
        $titleMemberName = 'Name of Member',
        $isRequiredMemberType = 'required',
        $isRequiredCig = 'required',
        $isRequiredCigMember = 'required',
        $isRequiredFarmer = 'required'
    )
    {
        $this->titleMemberType = $titleMemberType; 
        $this->titleMemberName = $titleMemberName; 
        $this->isRequiredMemberType = $isRequiredMemberType; 
        $this->isRequiredCig = $isRequiredCig; 
        $this->isRequiredCigMember = $isRequiredCigMember; 
        $this->isRequiredFarmer = $isRequiredFarmer; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $data['farmerList']  = FarmerModel::getFarmerList();
        $data['ethnicCommunity']    = CommonLabel::getCLWithKeyValue('ethnic-community');
        $data['genderList']         = genders();
        $data['cigs']         = Cig::getCigList();
        $data['cigMembers']         = CigMember::getCigMemberListByCigId();
        $data['titleMemberType'] = $this->titleMemberType; 
        $data['titleMemberName'] = $this->titleMemberName;
        $data['isRequiredMemberType'] = $this->isRequiredMemberType; 
        $data['isRequiredCig'] = $this->isRequiredCig; 
        $data['isRequiredCigMember'] = $this->isRequiredCigMember; 
        $data['isRequiredFarmer'] = $this->isRequiredFarmer; 
        // dd($data['isRequiredCig']);
        return view('components.farmer', $data);
    }
}
