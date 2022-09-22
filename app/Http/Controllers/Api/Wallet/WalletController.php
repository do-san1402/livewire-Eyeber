<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\CoinLogResource;
use App\Http\Resource\PaginateResource;
use App\Http\Resource\WalletDetailResouce;
use App\Http\Resource\WalletResouce;
use App\Models\Coin;
use App\Models\CoinLog;
use App\Models\UserWallet;
use App\Models\WalletAddressHistory;
use App\Services\Wallets\WalletService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WalletController extends BaseController
{
    private $walletService;

    public function __construct(WalletService $walletService) {
        $this->walletService = $walletService;
    }
    public function wallet()
    {
        $user = Auth::user();
        $wallet = WalletService::wallet($user->id);
        return $this->sendResponse(new WalletResouce($wallet),'Wallet success');
    }

    public function detail($id)
    {
        $user = Auth::user();
        $wallet = UserWallet::where('user_id', $user->id)->where('id', $id)->first();
        return $this->sendResponse(new WalletDetailResouce($wallet),'Wallet detail success');
    }

    public function history_deposit_and_withdraw($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data = $request->all();
        $user = Auth::user();
       
        $wallet = UserWallet::where('user_id', $user->id)->where('id', $id)->first();
        $coinLogs = new CoinLog();
        $coinLogs = $coinLogs->where('coin_id', $wallet->coin_id );
        $coinLogs = $coinLogs->where('user_id', $user->id );
        if(isset($data['status'])){
            $coinLogs = $coinLogs->where('status_classification_coin', $request->status);
        }
        $coinLogs = $coinLogs->paginate(5);
        return $this->sendResponse(new PaginateResource($coinLogs), 'Coin log success');
    }

    public function withdrawalRequest(Request $request) {
        try{
            $validator = Validator::make($request->all(), [
                'address' => 'required',
                'coin_id' => 'required',
                'amount' => 'required|numeric',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = Auth::user();
            $userWallet = UserWallet::where('coin_id', $request->coin_id)
            ->where('user_id',$user->id)
            ->where('status', config('apps.common.status_wallet.activate'))->first();
            $amount = (float)$request->amount;
            if($userWallet->amount < $amount){
                $data = [];
                $data['message'] = trans('translation.you_don_t_have_enough_money');
                $data['status'] = 1;
                return $this->sendResponse($data, "You don't have enough money");
            }
            
            $coinLog = new CoinLog();
            $coinLog ->address = $request->address;
            $coinLog ->coin_id =  $request->coin_id;
            $coinLog ->user_id =  $user->id;
            $coinLog ->amount =  $request->amount;
            $coinLog ->status_classification_coin =  config('apps.common.status_classification_coin.withdrawal');
            $coinLog ->status_log_coin =  config('apps.common.status_log_coin.wait_for_confirm');
            $coinLog ->date_start = Carbon::now()->format('Y-m-d');
            $coinLog ->date_end = Carbon::now()->format('Y-m-d');
            $coinLog->save();
            return $this->sendResponse(['message' => trans('translation.wait_for_confirm')], 'Wait for confirmation');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError(
                "withdrawal request Fail",
                ['error' => trans('translation.withdrawal_request')]
            );
        }
    }

    public function getDepositWalletInformation() {
        $user = Auth::user();
        $wallet = WalletAddressHistory::where('user_id', $user->id)->latest()->first();
        if(!$wallet) {
            return $this->sendError(
                trans('translation.The_deposit_wallet_information_not_found'),
                ['error' =>  trans('translation.The_deposit_wallet_information_not_found')] 
            );
        }
        return $this->sendResponse([
            'QR' => (string) QrCode::generate($wallet->address),
            'wallet_address' => $wallet->address
        ], trans('translation.Get_deposit_wallet_information_success'));

    }  

    public function updateWallet($wallet_id)
    {
        $user = Auth::user();
        $wallet = UserWallet::find($wallet_id);
        if(!$wallet){
            return $this->sendError(
                trans('translation.update_fail'),
                ['error' =>  trans('translation.update_fail')] 
            );
        }
        $data = $this->walletService->updatebalance($user->id,  $wallet->coin_id );
        if($data['status']){
            return $this->sendResponse(new WalletDetailResouce($data['wallet']), $data['message']);
        }
        return $this->sendResponse(new WalletDetailResouce($data['wallet']), $data['message']);
    }
    
}