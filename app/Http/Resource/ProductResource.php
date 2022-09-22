<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class ProductResource extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $available_coins = config('apps.common.available_coins');
        foreach($available_coins as $key => $status){
            if((int)$status === (int) $this->available_coins_id){
                $available_coins_id = trans('translation.'. $key);
            }
        }
       return [
            'product_id' => $this->id,
            'name' =>  $this->name_glass,
            'description' => $this->description,       
            'level' => $this->level,
            'mining' => $this->mining,
            'durability' => $this->durability,
            'product_upgrade' => $this->product_upgrade,
            'repair_cost' => $this->repair_cost,
            'of_mining' => $this->of_mining,
            'durability_used' => $this->durability_used,  
            'available_coins' => $available_coins_id,
            'decrease' => $this->decrease,
            'mining_amount_when_decreasing' => $this->mining_amount_when_decreasing,
            'image_url' => $this->image_url,
            'price_MATIC' => $this->price_matic,
            'price_KRW' => $this->price_krw,
            'price_USD'=> $this->price_usd,
        ];

    }
}
