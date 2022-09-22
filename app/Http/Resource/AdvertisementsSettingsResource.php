<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class AdvertisementsSettingsResource extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_inventory_id' => $this->product_inventory_id,
            'product_inventory_name' => $this->product_inventory->product_inventory_name,
            'time' => $this->time
        ];

    }
}
