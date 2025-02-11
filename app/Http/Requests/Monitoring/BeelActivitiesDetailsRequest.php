<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class BeelActivitiesDetailsRequest extends FormRequest
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
            'beel_activities_id'                 => 'required',
            'type_of_beel_development_activity'  => 'required',
            'gov_investment'                     => 'required',
            'cbo_investment'                     => 'required',
            'total_return'                       => 'required',
            'net_return'                         => 'required',
            'individual_benefit'                 => 'required',
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
            'beel_activities_id.required'                => __('Please select Beel Activitiy.'),
            'type_of_beel_development_activity.required' => __('Please select Type of Development Activity.'),
            'gov_investment.required'                    => __('Please Provide GOV investment.'),
            'cbo_investment.required'                    => __('Please Provide CBO investment.'),
            'total_return.required'                      => __('Please provide Total return.'),
            'net_return.required'                        => __('Please provide Net return.'),
            'individual_benefit.required'                => __('Please provide Individual benefit.'),
        ];
    }
}
