<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class CIGAccountTransactionRequest extends FormRequest
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
        $rules = [
            'organization_id' => 'required',
			'cig_id' => 'required',
        ];
        if (auth()->user()->organization_id == config('app.organization_id_dls')) {
            $rules['financial_year_id'] = 'required';
            $rules['transaction_month'] = 'required';
        } else {
            $rules['transaction_type_id'] = 'required';
			$rules['deposite_type_id'] = 'required';
			$rules['date_of_transaction'] = 'required';
			$rules['amount'] = 'required';
        }
        return $rules;
    }
}
