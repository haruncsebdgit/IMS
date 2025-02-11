<?php

namespace App\Http\Requests\Monitoring\Environmental;

use Illuminate\Foundation\Http\FormRequest;

class AquaculturepracticeRequest extends FormRequest
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
            'cig_id'                                            => 'required',
            'programme_date'                                    => 'required',
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
