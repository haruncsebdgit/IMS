<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class InfertilityCampaignRequest extends FormRequest
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
            'cig_id' => 'required',
            'financial_years_id' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'upazila_id' => 'required'
        ];
    }
}
