<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvItemInformationRequest extends FormRequest
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
            'name_en' => [
                "required",
                Rule::unique('inv_item_category_sub_category_information')
                         ->where(function ($query) {
                             return 
                             $query->where('name_en', $this->name_en);
                         })
                         ->ignore($this->id)],
            'code_en' => [
                "required",
                Rule::unique('inv_item_category_sub_category_information')
                         ->where(function ($query) {
                             return 
                             $query->where('code_en', $this->code_en);
                         })
                         ->ignore($this->id)],
            'asset_type' => "required",
            'category_id'=> "required"
        ];
    }
}
