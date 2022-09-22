<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;


class NoticeResouce extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       return [
          'notice_id' => $this->id,
          'title' => $this->title,                         
          'views' => $this->views,                         
          'status' => $this->status,                         
          'content' => $this->content,                         
        ];
    }
}