<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CIGRequest extends FormRequest
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
            'organization_id' => 'required',
            'division_id' => 'required',
			'district_id' => 'required',
			'upazila_id' => 'required',
			'union_id' => 'required',
			'cig_name' => 'required',
			'cig_address' => 'required',
			'establish_date' => 'required',
			'cig_category' => 'required'
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
            'division_id.required' => __('Please select division.')
        ];
    }
}
