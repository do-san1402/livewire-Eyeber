<?php

namespace App\Http\Resource;

use App\Models\WalletAddressHistory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class WalletResouce extends ResourceCollection{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        foreach($this->collection as $key =>  $wallet){
            $array[] = [
                'amount' => $wallet->amount,
                'address' => $wallet->polygon_address,
                'status' => $wallet->status,
                'coin_name' => $wallet->coin_name,
                'image_url' => $wallet->coin_image,
                'status_name' => $wallet->status_name,
                'id' => $wallet->id,
                'symbol_name' => $wallet->coin_symbol_name
            ];
           
        }
       return $array;
    }
}