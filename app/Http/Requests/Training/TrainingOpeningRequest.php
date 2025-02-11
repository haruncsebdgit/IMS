<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class TrainingOpeningRequest extends FormRequest
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

            'financial_year_id' => 'required',
            'opening_date' => 'required',
            'training_type_id' => 'required',
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
            'opening_date.required' => __('Please Enter Opening Date.'),
            'financial_year_id.required' => __('Please Select A Financial Year .'),
            'training_type_id.required' => __('Please Select A Training Type .'),

        ];
    }
}
