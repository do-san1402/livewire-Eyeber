<?php

namespace App\Http\Controllers\Api\Coin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\WalletDetailResouce;
use App\Models\Coin;
use App\Models\SettingCommon;
use App\Models\UserWallet;
use App\Services\Coins\CoinService;
use App\Services\Wallets\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CoinController extends BaseController
{
    public function swap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'coin_exchange' => 'required',
            'coin_receive' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $coin_exchange = $request->coin_exchange;
        $coin_receive = $request->coin_receive;
        $amount = $request->amount;
        $amount = (float)$amount;
        $user = Auth::user();
        $swap = CoinService::swap($coin_exchange, $amount, $coin_receive, $user->id);
        if(!$swap['status']){
            return $this->sendResponse($swap, $swap['error']);
        }
       
        return $this->sendResponse($swap, 'Here is the amount of coinsconverted');
    }

    public function index()
    {
      $coin = Coin::all();
      return $this->sendResponse($coin, 'List Coin success');
    }

    public function confirm_swap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'coin_exchange' => 'required',
            'coin_receive' => 'required',
            'swap' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try{
            DB::beginTransaction();
            $coin_exchange = $request->coin_exchange;
            $coin_receive = $request->coin_receive;
            $amount = $request->amount;
            $amount = (float)$amount;
            $user = Auth::user();
            $swap = CoinService::swap($coin_exchange, $amount, $coin_receive, $user->id);
            if(!$swap['status']){
                return $this->sendResponse($swap, $swap['error']);
            }
            $array_coin = [
                $coin_exchange => $amount,
            ];
            $wallet_service = WalletService::coinCharge($user->id,$array_coin);
            if(!$wallet_service['status']){
                return $this->sendError($wallet_service['message'], ['error' => $wallet_service['error']]);
            }
    
            $user_wallet = UserWallet::where('user_id', $user->id)->where('coin_id', $coin_receive)->where('status', config('apps.common.status_wallet.activate'))->first();
            $user_wallet->amount =  $user_wallet->amount + $swap['amount'];
            $user_wallet->save();
            DB::commit();
            return $this->sendResponse($user_wallet, 'Swap success');
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return $this->sendError('Swap fail', ['error' => 'Swap fail']);
        }
        
    }

    public function wallet($coin_id)
    {
        $user = Auth::user();
        $wallet = UserWallet::where('user_id', $user->id)->where('coin_id', $coin_id)->first();
        $wallet = UserWallet::where('user_id', $user->id)->where('coin_id', $coin_id)->where('status', config('apps.common.status_wallet.activate'))->first();
        return $this->sendResponse(new WalletDetailResouce($wallet),'Wallet detail success');
    }


}