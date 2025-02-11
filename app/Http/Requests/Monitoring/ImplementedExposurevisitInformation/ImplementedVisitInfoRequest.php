<?php

namespace App\Http\Requests\Monitoring\ImplementedExposurevisitInformation;

use Illuminate\Foundation\Http\FormRequest;

class ImplementedVisitInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'division_id'                                       => 'required',
            'district_id'                                       => 'required',
            'upazila_id'                                        => 'required',
            'financial_year_id'                                 => 'required',
            'visited_date'                                      => 'required',
            'visited_place'                                     =>'required',
            'exhibited_technology_id'                           => 'required',
            'number_of_female_farmer'                           =>'required',
            'num_of_farmer_interseted_about_exhibited_tech'     =>'required',
            'dae_crop_id'                                       =>'sometimes|required',
            'dae_season_id'                                     =>'sometimes|required',
            'dae_justification_for_select_place'                =>'sometimes|required',
    ];
    }

    public function messages()
    {
        return [
            'division_id.required'          => __('Please select division.'),
            'district_id.required'          => __('Please select district.'),
            'upazila_id.required'           => __('Please select upazila.'),
        ];
    }
}
