<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VaccinationCampaignInformationRequest extends FormRequest
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
        ];
    }
}
