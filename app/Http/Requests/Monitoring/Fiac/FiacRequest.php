<?php

namespace App\Http\Requests\Monitoring\Fiac;

use Illuminate\Foundation\Http\FormRequest;

class FiacRequest extends FormRequest
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
                'division_id'           => 'required',
                'district_id'           => 'required',
                'upazila_id'            => 'required',
                'fiac_name'            => 'sometimes|required',
                'fiac_address'          => 'sometimes|required',
                'dae_fiac_block_name'   => 'sometimes|required',
                'dls_fiac_establish_date'=>'sometimes|required',
                'establish_phase'       => 'sometimes|required'
        ];
    }

    public function messages()
    {
        return [
            'division_id.required'          => __('Please select division.'),
            'district_id.required'          => __('Please select district.'),
            'upazila_id.required'           => __('Please select upazila.'),
        ];
    }
}
