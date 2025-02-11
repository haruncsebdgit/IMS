<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class FishSpeciesRequest extends FormRequest
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
            'name_bn' => 'required',
            'name_en' => 'required',
            'scientific_name_en' => 'required',
            'scientific_name_bn' => 'required',
            'fish_culture_type' => 'required',
            'isSIS' => 'required',
            'isRare' => 'required',
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
            'name_en.required' => __('Common Name (In English) Field Is Required .'),
            'name_bn.required' => __('Local Name (In Bangla) Field Is Required .'),
            'scientific_name_en.required' => __('Scientific Name (In English) Field Is Required .'),
            'scientific_name_bn.required' => __('Scientific Name (In Bangla) Field Is Required .'),
            'fish_culture_type.required' => __('Fish Culture Type Field Is Required .'),
            'isSIS.required' => __('Is Small Indegenous Species? Field Is Required .'),
            'isRare.required' => __('Is Rare? Field Is Required.'),

        ];
    }
}
