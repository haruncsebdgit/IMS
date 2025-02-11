<?php

namespace App\Http\Requests\Monitoring\Demonstration;

use Illuminate\Foundation\Http\FormRequest;

class DemonstrationsRequest extends FormRequest
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
            'financial_year_id'     => 'required'
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
            'financial_year_id.required'    => __('Please select Financial year.'),
            'division_id.required'          => __('Please select division.'),
            'district_id.required'          => __('Please select district.'),
            'upazila_id.required'           => __('Please select upazila.')
        ];
    }
}
