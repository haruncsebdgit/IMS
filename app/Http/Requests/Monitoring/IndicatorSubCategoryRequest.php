<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndicatorSubCategoryRequest extends FormRequest
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
            'name_en' => [
                           "required",
                           "max:255",
                           Rule::unique('indicator_sub_categories')
                                    ->where(function ($query) {
                                        return 
                                        $query->where('name_en', $this->name_en);
                                    })
                                    ->ignore($this->id)],
            'name_bn'  => 'required|max: 255',
            'code' => 'required|numeric'
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
            'name_en.required' => __('Please Provide Name in English.'),
            'name_bn.required' => __('Please Provide Name in Bengali.'),
            'code.required' => __('Please Provide Code.')
        ];
    }
}
