<?php

namespace App\Services\Advertisements;

use App\Models\User;

class AdvertisementService{

    public static function postMessagePopup($user_id)
    {
        $user = User::find($user_id);
        if(!count($user->product_inventory)){
            return [
                'status' => 1,
                'error' => trans('translation.error_when_without_glass'),
                'message' => trans('translation.Buy_Glass') 
            ];
        }
        if(!$user->advertisements_setting){
            return [
                'status' => 2,
                'error' => trans('translation.non_set_up_ads'),
                'message' => trans('translation.let_set_up_ads')
            ];
        }
        if($user->advertisements_setting->product_inventory){
            if($user->advertisements_setting->product_inventory->durability <= 0){
                return [
                    'status' => 3,
                    'error' => trans('translation.You_have_used') . ' '. 
                    $user->advertisements_setting->product_inventory->product->name . ' '.
                    trans('translation.the_durability_of_It_has_reached_0'),
                    'message' => trans('translation.Repair_or_change_items'),
                ];
            }
          
        }
        return [
            'status' => 0,
            'message' => trans('translation.success') 
        ];
       

    }
}
