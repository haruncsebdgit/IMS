<?php

namespace App\View\Components;

use App\Models\Settings\District;
use App\Models\Settings\Division;
use App\Models\Settings\Organogram;
use App\Models\Settings\Region;
use App\Models\Settings\ThanaUpazila;
use App\Models\Settings\UnionWard;
use Illuminate\View\Component;

/**
 * Location (Division, District ... Union) component
 * Populating all location dropdown from user session location id and auto select specific location
 * 
 * @author Mohammad Harun-Or-Rashid
 */
class Location extends Component
{
    public $divisions = [];
    public $districts = [];
    public $upazilas = [];
    public $unions = [];

    public $divisionId;
    public $districtId;
    public $upazilaId;
    public $unionId;

    public $isDisabledDivisions = '';
    public $isDisabledDistricts = '';
    public $isDisabledUpazilas = '';
    public $isDisabledUnions = '';

    public $isShowDivisions = true;
    public $isShowDistricts = true;
    public $isShowUpazilas = true;
    public $isShowUnions = true;

    public $isRequiredDivisions = 'required';
    public $isRequiredDistricts = 'required';
    public $isRequiredUpazilas = 'required';
    public $isRequiredUnions = 'required';

    public $columnInRow = 3;

    // Determining if need to show division/district/upazila/union label
    public $isShowLabel = true;

    //public $division;
    /**
     * Create a new component instance.
     *  @param $divisionId
     *  @param $districtId
     *  @param $upazilaId
     *  @param $unionId
     *  @param $hides   Hide specific location. use ['union'=>1] to hide union
     *  @param $columnInRow Number of column in a row. default col-sm-3
     * @return void
     */
    public function __construct(
        $divisionId = null, 
        $districtId = null,
        $upazilaId = null,
        $unionId = null,
        $hides = [],
        $required = [],
        $columnInRow = 3,
        $isShowLabel = true
    ){
        
        $this->divisionId = $divisionId ?? session('selected_organogram_division_region_id');
        $this->districtId = $districtId ?? session('selected_organogram_district_id');
        $this->upazilaId = $upazilaId ?? session('selected_organogram_upazila_id');
        $this->unionId = $unionId ?? session('selected_organogram_union_id');

        if (!empty(session('selected_organogram_division_region_id'))){
            $this->isDisabledDivisions = 'disabled';
        }

        if (!empty(session('selected_organogram_district_id'))){
            $this->isDisabledDistricts = 'disabled';
        }

        if (!empty(session('selected_organogram_upazila_id'))){
            $this->isDisabledUpazilas = 'disabled';
        }
        if (!empty(session('selected_organogram_union_id'))){
            $this->isDisabledUnions = 'disabled';
        }

        $this->isShowLabel = $isShowLabel;
        $this->showHideLocation ($hides);
        $this->checkRequiredLocation ($required);
        $this->setAllLocation ();

        $this->columnInRow = $columnInRow;
    }

    public function checkRequiredLocation($required)
    {
        if(isset($required['union']) && $required['union'] == 0) {
            $this->isRequiredUnions = '';
        }
        if(isset($required['upazila']) && $required['upazila'] == 0) {
            $this->isRequiredUpazilas = '';
        }
        if(isset($required['district']) && $required['district'] == 0) {
            $this->isRequiredDistricts = '';
        }
        if(isset($required['division']) && $required['division'] == 0) {
            $this->isRequiredDivisions = '';
        }
    }

    public function showHideLocation($hides)
    {
        if(isset($hides['union']) && !empty($hides['union'])) {
            $this->isShowUnions = false;
        }
        if(isset($hides['upazila']) && !empty($hides['upazila'])) {
            $this->isShowUpazilas = false;
        }
        if(isset($hides['district']) && !empty($hides['district'])) {
            $this->isShowDistricts = false;
        }
        if(isset($hides['division']) && !empty($hides['division'])) {
            $this->isShowDivisions = false;
        }
    }

    public function setAllLocation ()
    {
        //$this->divisions = Division::getDivisionListArray();  
        if(auth()->user()->organization_id == config('app.organization_id_dae')) {
            $this->divisions = Region::getRegionsListArray();
        } else {
            $this->divisions = Division::getDivisionListArray();
        }

        if( !empty($this->divisionId)) {
            $this->districts = District::getDistrictListByDivisionId($this->divisionId);
        }

        if( !empty($this->districtId)) {
            $this->upazilas = ThanaUpazila::getDistrictWIseThanaUpazillaListWithKeyValuePair($this->districtId);
        }

        if( !empty($this->upazilaId)) {
            $this->unions = UnionWard::getUnionListByUpazilaId($this->upazilaId);
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $data['divisions'] = $this->divisions;
        $data['districts'] = $this->districts;
        $data['upazilas'] = $this->upazilas;
        $data['unions'] = $this->unions;

        // Determinig is disabled specific location
        $data['isDisabledDivisions'] = $this->isDisabledDivisions;
        $data['isDisabledDistricts'] = $this->isDisabledDistricts;
        $data['isDisabledUpazilas'] = $this->isDisabledUpazilas;
        $data['isDisabledUnions'] = $this->isDisabledUnions;

        $data['divisionId'] = $this->divisionId;
        $data['districtId'] = $this->districtId;
        $data['upazilaId'] = $this->upazilaId;
        $data['unionId'] = $this->unionId;

        $data['isShowDivisions'] = $this->isShowDivisions;
        $data['isShowDistricts'] = $this->isShowDistricts;
        $data['isShowUpazilas'] = $this->isShowUpazilas;
        $data['isShowUnions'] = $this->isShowUnions;

        $data['isRequiredDivisions'] = $this->isRequiredDivisions;
        $data['isRequiredDistricts'] = $this->isRequiredDistricts;
        $data['isRequiredUpazilas'] = $this->isRequiredUpazilas;
        $data['isRequiredUnions'] = $this->isRequiredUnions;

        $data['columnInRow'] = $this->columnInRow;

        $data['isShowLabel'] = $this->isShowLabel;
        return view('components.location', $data);
    }
}
