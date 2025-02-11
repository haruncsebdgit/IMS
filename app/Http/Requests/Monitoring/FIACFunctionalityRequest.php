<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class FIACFunctionalityRequest extends FormRequest
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
            'fiac_id' => 'required',
			'financial_years_id' => 'required',
			'reporting_month' => 'required'
			
        ];
    }

    public function messages()
    {
        return [
            'fiac_id.required'          => __('Please select FIAC.'),
            'financial_years_id.required'           => __('Please select Financial Year.'),
            'reporting_month.required'           => __('Please select Reporting Month.'),
        ];
    }
}
