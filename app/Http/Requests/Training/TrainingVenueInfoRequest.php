<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class TrainingVenueInfoRequest extends FormRequest
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
            'code'    => 'required',
            'name_en' => 'required',
            'is_active' => 'required',
            'district_id' => 'required',
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
            'code.required' => __('Please Input A Code .'),
            'district_id.required' => __('Please Select A District .'),

        ];
    }
}
