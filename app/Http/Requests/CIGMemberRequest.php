<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CIGMemberRequest extends FormRequest
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
            'cig_id' => 'required',
			'member_name' => 'required',
			'gender' => 'required',
			'is_ethnic' => 'required',
			'father_name' => 'required',
			'mother_name' => 'required',
			'nid' => 'required'
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
            'member_name.required' => __('Please write member name.')
        ];
    }
}
