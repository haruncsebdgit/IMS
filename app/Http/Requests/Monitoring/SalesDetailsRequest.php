<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class SalesDetailsRequest extends FormRequest
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
            'communication_channel_id' => 'required',
            'marketplace_type_id' => 'required',
            'transport_mode_id' => 'required',
            'marketplace_type_id' => 'required',
            'transport_media' => 'required',
			'po_sales_id' => 'required'
        ];
    }
}
