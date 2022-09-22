<?php

namespace App\Services\Coins;

use App\Models\Coin;
use App\Models\SettingCommon;
use App\Models\User;
use App\Models\UserWallet;

class CoinService{

    public static function swap($coin_exchange, $amount, $coin_receive, $user_id)
    {
        $data = []; 
        $data['status'] = 0;
        $user_wallet = UserWallet::where('user_id', $user_id)->where('coin_id', $coin_exchange)->where('status', config('apps.common.status_wallet.activate'))->first();
        $data['your_total_coin'] = $user_wallet->amount;
        $setting = SettingCommon::where('value->coin_exchange', $coin_exchange)->where('value->coin_receive', $coin_receive)->first();
        $coin_min = SettingCommon::where('key', 'min_'.$coin_exchange)->first();
        $coin = Coin::find($coin_exchange); 
        $min = (float)$coin_min->value;
        $data['min'] = $min;
        if(!$setting){
            $data['amount'] = 0;
            $data['balance'] = trans('translation.Not_havent_yet_balance');
            $data['message'] = trans('translation.Sorry_we_not_yet_setting_convert');
            $data['error'] = 'Sorry we not yet setting convert';
            return $data;
        }
        $value = json_decode($setting->value);
        $rate = $value->rate;
        $data['balance'] =  1 .' ' .$coin->symbol_name . ' : ' . $rate . ' ' . Coin::find($coin_receive)->symbol_name;
        $amount_coin_receive = $amount * $rate;
        $data['amount'] = $amount_coin_receive;
        if($user_wallet->amount < $amount){
            $data['message'] = trans('translation.You_have_not_enough_coin_to_swap');
            $data['error'] = 'You have not enough coin to swap';
            return $data;
        }
        if($amount < $min){
            $data['message'] = trans('translation.coin_has_exceeded_minimum_coin');
            $data['error'] = 'Coin has exceeded minimum coin';
            return $data;
        }
        $data['status'] = 1;
        $data['message'] = trans('translation.Here_is_the_amount_of_coins_converted');
        return $data;
    }
}
