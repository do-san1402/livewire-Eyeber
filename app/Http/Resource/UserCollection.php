<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       $array = [];
       foreach($this->collection as $user){
        $array[]= [
            'user_id' => $user->id,
            'nick_name' => $user->nick_name,
            'number_phone' => $user->number_phone,
            'full_name' =>  $user->full_name,                               
            'email' =>  $user->email,                       
          ];
       }
       return  $array;
    }
}
