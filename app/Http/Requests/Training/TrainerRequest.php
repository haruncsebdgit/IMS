<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class TrainerRequest extends FormRequest
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
            'trainer_type_id' => 'required',
            'gender' => 'required',
            'is_ethnic' => 'required',
            'nid' => 'required',
            'email' => 'required',
            'mobile' => 'required',
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
            'name_en.required' => __('Please Enter Your Name .'),
            'gender.required' => __('Please Select A Gender .'),
            'name_en.required' => __('Please Enter Your Name .'),
            'nid.required' => __('Please Enter Your NID Number .'),
            'email.required' => __('Please Enter Your Email .'),
            'mobile.required' => __('Please Enter Your Mobile Number .'),
            'trainer_type_id.required' => __('Please Select A Trainee.'),

        ];
    }
}
