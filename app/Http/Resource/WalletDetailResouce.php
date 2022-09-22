<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class WalletDetailResouce extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_wallet_id' => $this->id,
            'address' => $this->polygon_address,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'coin_image' =>  $this->coin_image,                                  
            'coin_name' =>  $this->coin_name,
            'amount' => $this->amount,                                  
          ];
    }
}