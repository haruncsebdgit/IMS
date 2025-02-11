<?php

namespace App\Http\Requests\Monitoring\AIF;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FundTypeRequest extends FormRequest
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
                'required', Rule::unique('aif_fund_types')
                ->where(function ($query) {
                    return 
                    $query->where('organization_id', auth()->user()->organization_id);
                })
                ->ignore($this->id)
            ],
			'name_bn' => [
                'required', Rule::unique('aif_fund_types')
                ->where(function ($query) {
                    return 
                    $query->where('organization_id', auth()->user()->organization_id);
                })
                ->ignore($this->id)
            ],
			'code' => [
                'required', Rule::unique('aif_fund_types')
                ->where(function ($query) {
                    return 
                    $query->where('organization_id', auth()->user()->organization_id);
                })
                ->ignore($this->id)
            ],
			'matching_grant_percent' => 'required',
			'matching_grant_bdt' => 'required'
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
            'name_en.unique' => __('Name (English) used before. Please try new one.'),
            'name_bn.unique' => __('Name (Bengali) used before. Please try new one.'),
            'code_en.unique' => __('Code (English) used before. Please try new one.'),
            'code_bn.unique' => __('Code (Bengali) used before. Please try new one.')
        ];
    }
}
