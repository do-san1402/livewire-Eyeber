<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'nick_name'  => 'required|string',
            'full_name'  => 'required|string',
            'rank_id'  => 'required',
            'number_phone'  => 'required|string',
            'email'  => 'required|email|unique:users',
            'password'  => 'required',
        ];
    }
    public function messages(){
        return [
        'nick_name.required'    => trans('translation.Please_enter_ID'),
        'full_name.required'    => trans('translation.Please_enter_full_name'),
        'rank_id.required'      => trans('translation.Please_select_rank'),
        'number_phone.required' => trans('translation.Please_enter_phone'),
        'email.required' => trans('translation.Please_enter_email'),
        'email.unique' => trans('translation.Email_already_exists'),
        'password.required' => trans('translation.Please_enter_password')
        ];
    }
}
