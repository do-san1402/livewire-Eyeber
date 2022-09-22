<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
           
            'sale_status_id'  => 'required',
            'image' => 'image',
            'durability'=> 'required',
            'glass' => 'required'
        ];
    }
    public function messages(){
        return [
        'name.required'         => trans('translation.Please_enter_name'),
        'description.required'    => trans('translation.Please_enter_description'),
        'price_matic.required'    => trans('translation.Please_enter_price_matic'),
        'repair_cost.required'    => trans('translation.Please_enter_repair_cost'),
        'sale_status_id.required'    => trans('translation.Please_enter_sale_status_id'),
        'image.required'    => trans('translation.Please_enter_image'),
        'durability.required'    => trans('translation.Please_enter_durability'),
        ];
    }
}
