<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'  => 'required|string',
            'description'  => 'required|string',
            'price_matic'  => 'required|numeric',
            'image' => 'required|image',
            'mining_amount_when__decrease' => 'required',
            'decrease' => 'required',
            'durability'=> 'required',
            'glass' => 'required',
            'available_coin_id' => 'required',
        ];
    }
    public function messages(){
        return [
        'name.required'         => trans('translation.Please_enter_name'),
        'description.required'    => trans('translation.Please_enter_description'),
        'price_matic.required'    => trans('translation.Please_enter_price_matic'),
        'sale_status_id.required'    => trans('translation.Please_enter_sale_status_id'),
        'image.required'    => trans('translation.Please_enter_image'),
        'mining_amount_when__decrease.required'    => trans('translation.Please_enter_mining_amount_when__decrease'),
        'decrease.required'    => trans('translation.Please_enter_decrease'),
        'durability.required'    => trans('translation.Please_enter_durability'),
        'glass.required'    => trans('translation.Please_enter_glass'),
        'available_coin_id.required'    => trans('translation.Please_enter_coin_type'),
        ];
    }
}
