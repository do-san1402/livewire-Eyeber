<?php

namespace App\Services\Wallets;

use App\Models\Coin;
use App\Models\CoinLog;
use App\Models\UserWallet;
use App\Models\WalletAddressHistory;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class WalletService
{
    private $link_transaction;
    private  $provider_type;
    public function __construct() {
        $this->link_transaction = config('apps.common.link_transaction');
        $this->provider_type = config('apps.common.provider_type');
    }

    public static function wallet($user_id)
    {
        $wallet = UserWallet::where('user_id', $user_id)->get();
        return $wallet;
    }

    public static function generateAddress()
    {
        return Str::random(50);
    }

    public static function coinCharge($user_id, $array_coin)
    {
        try{
            DB::beginTransaction();
            $user_wallets = UserWallet::where('user_id', $user_id)
                ->where('status', config('apps.common.status_wallet.activate'))->get();
               
                if(!count($user_wallets)){
                    return  [
                        'status' => 0,
                        'message' => "You don't have enough money",
                        'error' => trans('translation.you_don_t_have_enough_money')
                    ];
                }
                foreach ($array_coin as $coin_id => $coin) {
                    $coinCheck = $user_wallets->filter(function ($value, $key) use($coin_id) {
                      return (int)$value->coin_id === (int)$coin_id;
                    });
                    if(!count($coinCheck) || count($coinCheck)>1){
                      
                        return  [
                            'status' => 0,
                            'message' => "You don't have enough money",
                            'error' => trans('translation.you_don_t_have_enough_money')
                        ];
                    }
                    $wallet =  $coinCheck->first(); 
                    if($wallet->amount >= $coin){
                        $wallet->amount = $wallet->amount - $coin;
                        $wallet->save();
                        $admin_wallet = Coin::where('id', $coin_id)->first()->admin_wallet;
                        $admin_wallet->amount =  $admin_wallet->amount + $coin;
                        $admin_wallet->save();
                    }else{

                        return  [
                            'status' => 0,
                            'message' => "You don't have enough money",
                            'error' => trans('translation.you_don_t_have_enough_money')
                        ];
                    }
                    
                   
                   
                }
           
            DB::commit();
            return  [
                'status' => 1,
                'success' => trans('translation.success'),
            ];
        }catch(Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return  [
                'status' => 0,
                'message' => "Failed to make a successful payment",
                'error' => trans('translation.failed_to_make_a_successful_payment')
            ];
        }
        
    }

    public static function getReward($array_coin, $user_id)
    {
        try{
            DB::beginTransaction();
            $user_wallets = UserWallet::where('user_id', $user_id)
            ->where('status', config('apps.common.status_wallet.activate'))
            ->get();
            if(!count($user_wallets)){
                return  [
                    'status' => 0,
                    'message' => "You don't have wallet",
                ];
            }
            foreach ($array_coin as $coin_id => $coin) {
                $coinCheck = $user_wallets->filter(function ($value, $key) use($coin_id) {
                return (int)$value->coin_id === (int)$coin_id;
                });
                if(!count($coinCheck) || count($coinCheck)>1){
                    return  [
                        'status' => 0,
                        'message' => "You don't have enough money",
                        'error' => trans('translation.you_don_t_have_enough_money')
                    ];
                }
                $wallet =  $coinCheck->first(); 
                $wallet->amount = $wallet->amount + $coin;
                $wallet->save();
            }
            DB::commit();
            return  [
                'status' => 1,
                'success' => trans('translation.success'),
            ];
        }catch(Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return  [
                'status' => 0,
                'message' => "Failed to make a successful payment",
                'error' => trans('translation.failed_to_make_a_successful_payment')
            ];
        }
    }

    public function post($header, $endPoint, $dataPost)
    {
        $url =  $this->link_transaction . $endPoint;
        $response = Http::withHeaders($header)->post($url, $dataPost);
        if($response->getStatusCode() === Response::HTTP_OK){
            $response = $response->json();
            if(isset($response['data']['receipt'])){
                $response = $response['data']['receipt'];
            }else{
                $response = $response['data'];
            }
            return $response;
        }
        $response = $response->json();
        $data = [];
        $data['status'] =  0;
        $data['message'] = $response['message'];
        return $data;
    }

    public function get($header, $endPoint, $dataGet)
    {
        
        $url =  $this->link_transaction . $endPoint;
      
        $response = Http::withHeaders($header)->get($url,$dataGet );
        if($response->getStatusCode() === Response::HTTP_OK){
            $response = $response->json();
            if(isset($response['data']['receipt'])){
                $response = $response['data']['receipt'];
            }else{
                $response = $response['data'];
            }
            return $response;
        }
        $response = $response->json();
        $data = [];
        $data['status'] =  0;
        $data['message'] = $response['message'];
        return $data;
    }

    public function updatebalance($user_id, $coin_id)
    {
        try{
            $coin = Coin::find($coin_id);
            $walletAddressHistory = WalletAddressHistory::where('user_id', $user_id)->latest()->first();
            $address = '';
            if($walletAddressHistory){
                $address = $walletAddressHistory->address;
            }
            $unit = strtolower($coin->symbol_name);
            $header = [
                'accept' => 'application/json',
                'Content-Type' => 'application/json'
            ];
            $endPoint = '/api/wallet/balance';
            $dataGet = [
                'providerType' => $this->provider_type,
                'address' =>  $address,
                'currency' => $unit,
                'unit' => 'wei'
            ];
            $data = [];
            $data['status'] = 0;
            $data['message'] =  trans('translation.no_change_in_your_wallet');
            $response = $this->get($header, $endPoint, $dataGet);
            $userWallet = UserWallet::where('user_id', $user_id)
            ->where('coin_id', $coin_id)
            ->where('status', config('apps.common.status_wallet.activate'))->first();
            $walletAddressHistoryArray =  $walletAddressHistory->toArray();
            $amount_wallet = $walletAddressHistoryArray['coin_' . $unit];
            if(is_string($response)){
                $response = (float) $response;
                $response =  $response / pow(10, 18);
                if((float)$amount_wallet === (float)0){
                    if (abs(($response - $amount_wallet)) > 0.00001){
                        $balance = $response - $amount_wallet;
                        $log = new CoinLog();
                        $log->status_classification_coin  = config('apps.common.status_classification_coin.deposit');
                        $log->date_start = date('y-m-d');
                        $log->user_id =  $user_id;
                        $log->coin_id =  $coin_id;
                        $log->status_log_coin =  config('apps.common.status_log_coin.deposit_success');
                        $log->amount = $balance;
                        $log->address = $address;
                        $log->date_end = date('y-m-d');
                        $log->save();
                        $walletAddressHistoryArray['coin_' . $unit] =  $amount_wallet + $balance;
                        $walletAddressHistory->update($walletAddressHistoryArray);
                        $userWallet->amount = $userWallet->amount + $balance;
                        $userWallet->save();
                        $data['status'] = 1;
                        if($balance > 0){
                            $data['message'] = trans('translation.there_has_been_a_change_in_your_wallet_increase_to',['amount' => $balance, 'coin' => $coin->symbol_name]);
                        }else{
                            $data['message'] =  trans('translation.there_has_been_a_change_in_your_wallet_reduce_to',['amount' => $balance, 'coin' => $coin->symbol_name]);
                        }
                    }
                }else{
                    if (abs(($response - $amount_wallet)/$amount_wallet) > 0.00001) {
                        $balance = $response - $amount_wallet;
                        $log = new CoinLog();
                        $log->status_classification_coin  = config('apps.common.status_classification_coin.deposit');
                        $log->date_start = date('y-m-d');
                        $log->user_id =  $user_id;
                        $log->coin_id =  $coin_id;
                        $log->status_log_coin =  config('apps.common.status_log_coin.deposit_success');
                        $log->amount = $balance;
                        $log->address = $address;
                        $log->date_end = date('y-m-d');
                        $log->save();
                        $walletAddressHistoryArray['coin_' . $unit] =  $amount_wallet + $balance;
                        $update  = $walletAddressHistory->update($walletAddressHistoryArray);
                        $userWallet->amount = $userWallet->amount + $balance;
                        $userWallet->save();
                        $data['status'] = 1;
                        if($balance > 0){
                            $data['message'] = trans('translation.there_has_been_a_change_in_your_wallet_increase_to',['amount' => $balance, 'coin' => $coin->symbol_name]);
                        }else{
                            $data['message'] =  trans('translation.there_has_been_a_change_in_your_wallet_reduce_to',['amount' => $balance, 'coin' => $coin->symbol_name]);
                        }

                    }
                }
                
            }
            $data['wallet'] = $userWallet;
            $data['log'] = $log ?? [];
            
            return $data;
        }catch(Exception $e){
           Log::error($e->getMessage());
           $log = new CoinLog();
           $log->status_classification_coin  = config('apps.common.status_classification_coin.deposit');
           $log->date_start = date('y-m-d');
           $log->user_id =  $user_id;
           $log->coin_id =  $coin_id;
           $log->status_log_coin =  config('apps.common.status_log_coin.deposit_failed');
           $log->amount = $balance  ?? 0.0 ;
           $log->address = $address ?? '';
           $log->date_end = date('y-m-d');
           $log->save();
           $data['wallet'] = $user_wallets ?? [];
           $data['log'] = $log ?? [];

           return $data;
        }
    }

    public function transfer($unit, $fromAddress, $toAddrress, $amount, $privateKey)
    {
        $fromAddress =$fromAddress;
        $privateKey = $privateKey;
        $header = [
            'accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        $endPoint = '/api/wallet/transfer-'. $unit;
        $dataPost = [
            'providerType' => $this->provider_type,
            "fromAddress" => $fromAddress,
            "toAddress"=>  $toAddrress,
            "privateKey"=>  $privateKey,
            "value"=> $amount,
            "unit"=> "ether"
        ];
        // call api transfer
        $response = $this->post($header, $endPoint, $dataPost);

        return $response;
    }
}
