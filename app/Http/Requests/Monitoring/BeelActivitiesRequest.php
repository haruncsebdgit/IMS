<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class BeelActivitiesRequest extends FormRequest
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
            'beel_id'               => 'required',
            'allocation_amount'                 => 'required',
            'activity_period_date_from'          => 'required',
            'activity_period_date_to'          => 'required',
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
            'beel_id.required'              => __('Please provide Beel.'),
            'allocation_amount.required'    => __('Please provide allocation.'),
            'activity_period_date_from.required'         => __('Please provide period date from.'),
            'activity_period_date_to.required'         => __('Please provide eriod date to.'),
        ];
    }
}
