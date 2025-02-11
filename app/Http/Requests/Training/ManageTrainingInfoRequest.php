<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class ManageTrainingInfoRequest extends FormRequest
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
            'organization_id'                       => 'required',
            'financial_year_id'                     => 'required',
            'memo_no'                               => 'required',
            'memo_date'                             => 'required',
            'batch_no'                              => 'required',
            'training_type_id'                      => 'required',
            'training_title_id'                     => 'required',
            'training_duration'                     => 'required',
            'total_number_of_trainee'               => 'required',
            'training_venue_type'                   => 'required',
            'training_expenditure'                  => 'required',
            // 'max_time_participate_in_same_training' => 'required',
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
            'organization_id.required'                        => __('Please Provide A Organization.'),
            'financial_year_id.required'                      => __('Please Select A Financial year.'),
            'memo_no.required'                                => __('Please Provide Memo No.'),
            'memo_date.required'                              => __('Please Provide Memo Date.'),
            'batch_no.required'                               => __('Please Provide Batch No.'),
            'training_type_id.required'                       => __('Please Select A Training Type.'),
            'training_title_id.required'                      => __('Please Select A Training Title.'),
            'training_duration.required'                      => __('Please Provide Training Duration.'),
            'total_number_of_trainee.required'                => __('Please Provide Total Number of Trainee.'),
            'training_venue_type.required'                    => __('Please Provide Training Venue Type.'),
            'training_expenditure.required'                   => __('Please Training Expenditure.'),
            // 'max_time_participate_in_same_training.required'  => __('Please Provide Max time participate.'),

        ];
    }
}
