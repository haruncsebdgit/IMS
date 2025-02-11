<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class BeelAquaticSpeciesOrWeedRequest extends FormRequest
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
            'scientific_name_en' => 'required',
            'scientific_name_bn' => 'required',
            'isAquaticSpecies' => 'required',
            'isAquaticWeed' => 'required',
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
            'name_en.required' => __('Aquatic Weed Or Species Name Field Is Required.'),
            'name_bn.required' => __('Common Name (In English) Field Is Required .'),
            'common_name_en.required' => __('Local Name (In Bangla) Field Is Required .'),
            'scientific_name_en.required' => __('Scientific Name (In English) Field Is Required .'),
            'scientific_name_bn.required' => __('Scientific Name (In Bangla) Field Is Required .'),
            'isAquaticSpecies.required' => __('Is Aquatic Species? Field Is Required .'),
            'isAquaticWeed.required' => __('Is Aquatic Weed? Name Field Is Required.'),

        ];
    }
}
