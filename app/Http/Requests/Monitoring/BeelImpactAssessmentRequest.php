<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class BeelImpactAssessmentRequest extends FormRequest
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
            'organization_id'       => 'required',
            'division_id'           => 'required',
            'district_id'           => 'required',
            'upazila_id'            => 'required',
            'union_id'              => 'required',
            'village'               => 'required',
            'mouza'                 => 'required',
            'beel_name_en'          => 'required',
            'beel_name_bn'          => 'required',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'organization_id.required'      => __('Please select Organization.'),
            'division_id.required'          => __('Please select division.'),
            'district_id.required'          => __('Please select district.'),
            'upazila_id.required'           => __('Please select upazila.'),
            'village.required'              => __('Please provide village.'),
            'mouza.required'                => __('Please provide mouza.'),
            'beel_name_en.required'         => __('Please provide beel name.'),
            'beel_name_bn.required'         => __('Please provide beel name.'),
        ];
    }
}
