<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeccDeccUeccMeetingInformationRequest extends FormRequest
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
            'entry_by' => 'required',
            'date_of_meeting' => 'required',
            'number_of_participants' => 'required',
        ];
    }
}
