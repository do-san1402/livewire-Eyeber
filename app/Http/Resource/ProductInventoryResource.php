<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class ProductInventoryResource extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return [
          'product_inventory_id' => $this->id,
          'product' => $this->product_inventory_name,
          'product_id' =>  $this->product_id,
          'product_image' => $this->product->image_url,                    
          'user' => $this->user->full_name,                         
          'user_id' => $this->user_id,                         
          'durability' => $this->durability,                         
          'level' => $this->level, 
          'views' => $this->views,
          'serial_number_glass'  => $this->serial_number_glass
        ];
    }
}
