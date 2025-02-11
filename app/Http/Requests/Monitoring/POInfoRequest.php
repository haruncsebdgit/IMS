<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class POInfoRequest extends FormRequest
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
            'division_id' => 'required',
            'district_id' => 'required',
			'upazila_id' => 'required',
			'name' => 'required',
			'address' => 'required',
			'registration_no' => 'required',
			'registration_date' => 'required'
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
