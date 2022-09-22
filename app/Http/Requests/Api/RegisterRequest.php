<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'     => 'required|email|string|unique:users',
            'password'  => 'required|string',
            'full_name' => 'required|string',
            'nick_name' => 'required|string',
            'birthday'  => 'required|date',
            'gender'    => 'required',
            'nation_id' => 'required',
            'location_detail' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required'   => trans('translation.Enter_email_address'),
            'email.unique'   => trans('translation.Email_already_exists'),
            'email.email'   => trans('translation.email_must_to_format'),
            'password.required'=> trans('translation.Please_enter_password'),
            'password.string'=> trans('translation.Please_enter_password'),
            'full_name.string' => trans('translation.Please_enter_full_name'),
            'full_name.required' => trans('translation.Please_enter_full_name'),
            'nick_name.string' => trans('validation.nick_name'),
            'nick_name.required' => trans('validation.nick_name'),
            'birthday.date' => trans('validation.birthday'),
            'gender.required' => trans('validation.gender'),
            'nation_id.required' => trans('validation.Please_enter_nation_id'),
            'location_detail.required' => trans('validation.location_detail'),
        ];
    }
}
