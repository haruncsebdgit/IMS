<?php

namespace App\Http\Requests\Monitoring\Demonstration;

use Illuminate\Foundation\Http\FormRequest;

class CigNoncigGatheringInformationRequest extends FormRequest
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
            'division_id' => 'required',
			'district_id' => 'required',
			'upazila_id' => 'required',
			'union_id' => 'required',
			'cig_id' => 'required',
			'financial_year' => 'required',
            'gathering_date' => 'required',
            'number_of_cig_farmer_attended' => 'required',
            'number_of_noncig_farmer_attended' => 'required',
            'number_of_ethnic_farmer_attended' => 'required',
            'number_of_female_cig_farmer_attended' => 'required',
            'number_of_female_noncig_farmer_attended' => 'required',
            'number_of_female_ethnic_farmer_attended' => 'required',
        ];
    }
}
