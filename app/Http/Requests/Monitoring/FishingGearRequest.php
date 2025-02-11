<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class FishingGearRequest extends FormRequest
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
            'name_en' => 'required',
            'name_bn' => 'required',
            'common_name_en' => 'required',
            'common_name_bn' => 'required',
            'group_name_en' => 'required',
            'group_name_bn' => 'required',
            'fish_type_id' => 'required',
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
            'name_en.required' => __('Please Enter A Name .'),
            'name_bn.required' => __('Please Enter A Local Name .'),
            'common_name_en.required' => __('Please Enter A Common Name In English .'),
            'common_name_bn.required' => __('Please Enter A Common Name In Bengali .'),
            'group_name_en.required' => __('Please Enter A Group Name In English .'),
            'group_name_bn.required' => __('Please Enter A Group Name In Bengali .'),
            'fish_type_id.required' => __('Please Select A Fish Type.'),

        ];
    }
}
