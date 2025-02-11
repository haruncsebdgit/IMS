<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FiacEquipmentInformationRequest extends FormRequest
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
            'select_fiac' => 'required',
            'financial_year' => 'required',
            'entry_date' => 'required',
            'equipment_name' => 'required',
            'number_of_equipment' => 'required',
        ];
    }
}
