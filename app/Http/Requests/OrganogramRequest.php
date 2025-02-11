<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganogramRequest extends FormRequest
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
            'parent_id' => 'required',
            'name_en' => 'required',
            'name_bn' => 'required',
            'office_type' => 'required',
            'is_active' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'is_inventory_center' => 'required',
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
            'parent_id.required' => __('Please select parent node.')
        ];
    }
}
