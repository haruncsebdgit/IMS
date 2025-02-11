<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class PoMmcMemberRequest extends FormRequest
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
        return $this->getRules();
    }

    public function getRules()
    {
        switch (auth()->user()->organization_id) {
            case config('app.organization_id_dae'):
                return [
                    'po_id' => 'required',
                    'cig_member_id' => 'required',
                    'designation_id' => 'required',
                    'mobile' => 'required',
                    'gender' => 'required'
                ];
                break;
            case config('app.organization_id_dof'):
                return [
                    'po_id' => 'required',
                    'name_of_member' => 'required',
                    'father_name' => 'required',
                    'mother_name' => 'required',
                    'joining_date' => 'required',
                    'nid' => 'required',
                    'mobile' => 'required',
                    'gender' => 'required'
                ];
                break;
            default:
                return [];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'po_id.required' => __('Please select PO Information.')
        ];
    }
}
