<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'advertisement_name' => 'required|string',
            'description' => 'required|string',
            'date_end' => 'required|date',
            'date_start' => 'required|before:date_end|date',
            'mining_settings' => 'required',
            'set_collection_deduction' => 'required|integer',
            'ad_nation_id' => 'required',
            'video' => (!empty($this->video_hidden)) ? '' :'required',
            'advertisement_setting' => 'required_if:mining_settings,==,0',  
   
        ];
    }
    public function messages()
    {
        return [
            'advertisement_name.required'    => trans('validation.Please_enter_name'),
            'advertisement_name.string'    => trans('validation.Please_enter_correct_format'),
            'description.string'    => trans('validation.Please_enter_correct_format'),
            'description.required'    => trans('validation.Please_enter_description'),
            'date_end.required'    => trans('validation.Please_enter_date_end'),
            'date_end.date'    => trans('validation.Please_enter_correct_format'),
            'date_start.required'    => trans('validation.Please_enter_date_start'),
            'date_start.date'    => trans('validation.Please_enter_correct_format'),
            'date_start.before'    => trans('validation.Please_enter_start_date_that_is_less_than_the_end_date'),
            'mining_settings.required'    => trans('validation.Please_enter_mining_settings'),
            'set_collection_deduction.required'    => trans('validation.Please_enter_set_collection_deduction'),
            'set_collection_deduction.integer'    => trans('validation.Please_enter_correct_format'),
            'ad_nation_id.required'    => trans('validation.Please_enter_nation_id'),
            'video.required' => trans('validation.Please_enter_video'),
            'advertisement_setting.required_if'    => trans('validation.Please_enter_advertisement_setting'),
        ];
    }
}
