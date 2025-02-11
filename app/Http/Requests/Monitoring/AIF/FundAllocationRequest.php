<?php

namespace App\Http\Requests\Monitoring\AIF;

use Illuminate\Foundation\Http\FormRequest;

class FundAllocationRequest extends FormRequest
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
			'award_date' => 'required',
			'beneficiary_type' => 'required',
			'cig_po_member_id' => 'required_if:beneficiary_type,cig,po',
			'beneficiary_name_enterpreneur' => 'required_if:beneficiary_type,enterpreneurs',
			'enterpreneur_gender' => 'required_if:beneficiary_type,enterpreneurs',
			'enterpreneur_mobile' => 'required_if:beneficiary_type,enterpreneurs',
			'sub_project_type_id' => 'required',
			'sub_project_title' => 'required',
			'total_project_value' => 'required'
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
            'cig_po_member_id.required_if' => __('CIG / PO Member Field is mandatory'),
        ];
    }
}
