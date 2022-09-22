<?php

namespace App\Http\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\WalletAddressHistory;

class UserResource extends JsonResource{ 

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status_users = config('apps.common.status_user');
        foreach($status_users as $key => $status_user){
            if( (int)$this->status_user_id ===  (int)$status_user ){
                $this->status_user = trans('translation.'.$key);
            }
        }
       return [
          'user_id' => $this->id,
          'nick_name' => $this->nick_name,
          'number_phone' => $this->number_phone,
          'full_name' =>  $this->full_name,           
          'nation' =>  $this->nation->name,               
          'age' =>  $this->age,               
          'birthday' =>  $this->birthday,               
          'status_user' =>  $this->status_user,               
          'joining_form' =>  $this->joining_form->name,               
          'email' =>  $this->email,
          'avatar' => $this->avatar_url,
          'address' => $this->polygon_address,                   
        ];
    }
}