<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class AdvertisementResource extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return [
            'advertisement_id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'views' => $this->views,
            'rewards' => $this->rewards,
            'video_url'=> $this->video_url,
            'id_watchAdvertisementsLog' => $this->id_watchAdvertisementsLog,
        ];

    }
}
