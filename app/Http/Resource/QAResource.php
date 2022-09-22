<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class QAResource extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       
       return [
           'name' => $this->name,
           'description' => $this->description,
           'registration_date' => $this->registration_date,
           'status' => $this->status_name,
        ];

    }
}
