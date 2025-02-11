<?php

namespace App\Models;

use DB;
use App\Models\Settings\Division;
use App\Models\Settings\District;
use App\Models\Settings\ThanaUpazila;
use App\Models\Settings\UnionWard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class LocationDataForFilter extends Model
{
    public static function getLocationDataForFilter(){

        $data = array();
        $name = "name_en";
        if (config('app.locale') === "bn") {
            $name = "name_bn";
        }
        $disabled = 'disabled';
        $divisionModel        = new Division;
        $districtModel        = new District;
        $thanaUpazilaModel        = new ThanaUpazila;
        $unionWardModel        = new UnionWard;
        $data['division_disabled'] = '';
        $data['district_disabled'] = '';
        $data['thana_upazila_disabled'] = '';
        $data['union_ward_disabled'] = '';
        $data['division_id'] = null;
        $data['district_id'] = null;
        $data['thana_upazila_id'] = null;
        $data['union_ward_id'] = null;

        $user = Auth::user();


        if ( !empty($user->division_id) || !empty($user->district_id) || !empty($user->upazila_id) || !empty($user->union_id) ){
            //Division User

            if( !empty($user->division_id) ){
                $data['division_id'] = $user->division_id;
                $data['division_disabled'] = $disabled;
                $data['divisionList'] = $divisionModel->getDivisionById($user->division_id);

                $data['districtList'] = $districtModel->getListByDivisionId($user->division_id);
                $data['thanaUpazilaList'] = $thanaUpazilaModel->getUpazilaNameByDivisionId($user->division_id);
                $data['unionWardList'] = $unionWardModel->getUnionNameByDivisionId($user->division_id);

            }

            // DF, DDLG, DC - District User
            if(!empty($user->district_id)){

                $district_id = $user->district_id;
                $districtInfo = DB::table('districts')
                    ->where('id', $district_id)
                    ->get();
                $division_id = $districtInfo[0]->division_id;

                $data['division_id'] = $division_id;
                $data['district_id'] = $district_id;
                $data['division_disabled'] = $disabled;
                $data['district_disabled'] = $disabled;

                $data['divisionList'] = $divisionModel->getDivisionById($division_id);
                $data['districtList'] = $districtModel->getDistrictNameId($district_id);
                $data['thanaUpazilaList'] = $thanaUpazilaModel->getListByDistrictId(Auth::user()->district_id);
                $data['unionWardList'] = $unionWardModel->getUnionWardListByDistrictId(Auth::user()->district_id);

                if( !empty($user->upazila_id) ){
                    // UNO User
                    $data['division_disabled'] = $disabled;
                    $data['district_disabled'] = $disabled;
                    $data['thana_upazila_disabled'] = $disabled;
                    $data['thana_upazila_id'] = $user->upazila_id;

                    $data['thanaUpazilaList'] = DB::table("thana_upazilas")
                        ->where('is_active', 1)
                        ->where('id', $user->upazila_id)
                        ->select('name_en', 'name_bn', 'id')
                        ->get();

                    $data['unionWardList'] = DB::table("union_wards")
                        ->where('thana_upazila_id',  $user->upazila_id)
                        ->where('is_active', 1)
                        ->select('name_en', 'name_bn', 'id')
                        ->get();

                    if(!empty($user->union_id)){
                        // UPS User
                        $data['unionWardList'] = DB::table("union_wards")
                            ->where('id',  $user->union_id)
                            ->where('is_active', 1)
                            ->select('name_en', 'name_bn', 'id')
                            ->get();

                        $data['union_ward_disabled'] = $disabled;
                        $data['union_ward_id'] =  $user->union_id;

                    }

                }
            }


        }else{
            $data['divisionList'] = $divisionModel->getDivisionList();
            $data['districtList'] = $districtModel->getDistrictList();
            $data['thanaUpazilaList'] = $thanaUpazilaModel->getAllThanaUpazilas();
            $data['unionWardList'] = $unionWardModel->getUnionWard();
        }

        return $data;
    }

    public static function getLocationDataForReportFilter(){

        $data = array();
        $name = "name_en";
        if (config('app.locale') === "bn") {
            $name = "name_bn";
        }

        $divisionModel        = new Division;
        $districtModel        = new District;
        $thanaUpazilaModel    = new ThanaUpazila;
        $unionWardModel       = new UnionWard;


        $data['division_id'] = null;
        $data['district_id'] = null;
        $data['thana_upazila_id'] = null;
        $data['union_ward_id'] = null;

        $data['js_division'] = 'division';
        $data['js_district'] = 'district';
        $data['js_thana_upazila'] = 'thana-upazila';
        $data['js_union_ward'] = 'union-ward';

        $data['required_division'] = '';
        $data['required_district'] = '';
        $data['required_thana_upazila'] = '';
        $data['required_union_ward'] = '';

        $user = Auth::user();


        if ( !empty($user->division_id) || !empty($user->district_id) || !empty($user->upazila_id) || !empty($user->union_id) ){


            if( !empty($user->division_id) ){
                $data['division_id'] = $user->division_id;
                $data['required_division'] = 'required';
                $data['divisionList'] = $divisionModel->getDivisionById( $user->division_id );
                $data['districtList'] = $districtModel->getListByDivisionId($user->division_id);
                $data['thanaUpazilaList'] = $thanaUpazilaModel->getUpazilaNameByDivisionId($user->division_id);
                $data['unionWardList'] = $unionWardModel->getUnionNameByDivisionId($user->division_id);
            }

            if(!empty($user->district_id)){
                $district_id =  Auth::user()->district_id;
                $districtInfo = DB::table('districts')
                    ->where('id', $district_id)
                    ->get();
                $division_id = $districtInfo[0]->division_id;

                $data['division_id'] = $division_id;
                $data['district_id'] = $district_id;


                $data['js_division'] = '';

                $data['required_division'] = 'required';
                $data['required_district'] = 'required';


                $data['divisionList'] = $divisionModel->getDivisionById($division_id);
                $data['districtList'] = $districtModel->getDistrictNameId($district_id);
                $data['thanaUpazilaList'] = $thanaUpazilaModel->getListByDistrictId(Auth::user()->district_id);
                $data['unionWardList'] = $unionWardModel->getUnionWardListByDistrictId(Auth::user()->district_id);

                if(!empty($user->upazila_id)){
                    $data['thanaUpazilaList'] = DB::table("thana_upazilas")
                        ->where('is_active', 1)
                        ->where('id', $user->upazila_id)
                        ->select('name_en', 'name_bn', 'id')
                        ->get();
                    $data['unionWardList'] = DB::table("union_wards")
                        ->leftJoin('thana_upazilas', 'thana_upazilas.id', '=', 'union_wards.thana_upazila_id')
                        ->where('thana_upazilas.id', $user->upazila_id)
                        ->where('union_wards.is_active', 1)
                        ->select('union_wards.name_en', 'union_wards.name_bn', 'union_wards.id')
                        ->get();
                    if( !empty($user->union_id)){
                        $data['unionWardList'] = DB::table("union_wards")
                            ->where('id',  $user->union_id)
                            ->where('is_active', 1)
                            ->select('name_en', 'name_bn', 'id')
                            ->get();
                        $data['js_union_ward'] = '';
                        $data['union_ward_id'] =  $user->union_id;
                        $data['required_union_ward'] = 'required';
                    }


                    $data['js_division'] = '';
                    $data['js_district'] = '';
                    $data['js_thana_upazila'] = '';

                    $data['thana_upazila_id'] = $user->upazila_id;
                    $data['required_thana_upazila'] = 'required';

                }

            }

        }else{
            $data['divisionList'] = $divisionModel->getDivisionList();
            $data['districtList'] = [];
            $data['thanaUpazilaList'] = [];
            $data['unionWardList'] =[];
        }


        return $data;
    }


}
