<?php

namespace App\Http\Controllers\Api\Advertisements;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\AdvertisementResource;
use App\Http\Resource\AdvertisementsSettingsResource;
use App\Http\Resource\PaginateResource;
use App\Models\Advertisement;
use App\Models\ProductInventory;
use App\Models\AdvertisementsSettings;
use App\Models\Product;
use App\Models\UserWallet;
use App\Models\WatchAdvertisementsLog;
use App\Services\Advertisements\AdvertisementService;
use App\Services\Wallets\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Http\Response;

class AdvertisementsController extends BaseController
{
    public function list(Request $request)
    {
        $paginate_size =  $request->paginate_size ?? 4;

        $advertisements = Advertisement::query()->where('date_start', '<=', date('Y-m-d'))->where('date_end', '>=', date('Y-m-d'))->where('ad_status_id', config('apps.common.ads_status.show'))->paginate($paginate_size);

        return  $this->sendResponse(new PaginateResource($advertisements), 'Advertisement list success');
    }

    public function detail($id)
    {
        $advertisement = Advertisement::find($id);
        $user =  Auth::user();
        $error_popup = AdvertisementService::postMessagePopup($user->id);
        $watchAdvertisementsLog = new WatchAdvertisementsLog;
        $watchAdvertisementsLog->product_inventory_id = 0;
        $watchAdvertisementsLog->user_id = $user->id;
        $watchAdvertisementsLog->advertisement_id = $id;
        $watchAdvertisementsLog->rewards = 0;
        $watchAdvertisementsLog->view = 1;
        $watchAdvertisementsLog->time = 0;
        $watchAdvertisementsLog->cumulative_mining = 0;
        $watchAdvertisementsLog->status =  config('apps.common.status_watch_ad.pending');
        $watchAdvertisementsLog->save();
        $advertisement->id_watchAdvertisementsLog =  $watchAdvertisementsLog->id ;
        if ($error_popup['status']) {
            return $this->sendResponse(new AdvertisementResource($advertisement), $error_popup);
        }

        return $this->sendResponse(new AdvertisementResource($advertisement), 'Advertisement detail success');
    }
    public function setting_ad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_inventory_id' => 'required',
            'time' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $user = Auth::user();
            $user_id = $user->id;
            $time =  $request->time;
            $product_inventory_id = $request->product_inventory_id;
            $product_inventory = ProductInventory::where('user_id', $user_id)->where("id", $product_inventory_id)->first();
            if(!$product_inventory){
                return $this->sendError(
                    "You did not choose your product in inventory correctly",
                    ['error' => trans('translation.You_did_not_choose_your_inventory_correctly')]
                );
            }
            $setting_ad = AdvertisementsSettings::where('user_id', $user_id)->first();
            if ($setting_ad) {
                $setting_ad->update([
                    'time' => $time,
                    'product_inventory_id' => $product_inventory_id,
                    'user_id' => $user_id,
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                $setting_ad = new AdvertisementsSettings;
                $setting_ad->time = $time;
                $setting_ad->product_inventory_id = $product_inventory_id;
                $setting_ad->user_id = $user_id;
            }
            $setting_ad->save();
            return $this->sendResponse('success', 'Advertisement setting success');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError(
                "Setting Advertisement Fail",
                ['error' => trans('translation.Setting_advertisement_fail')]
            );
        }
    }

    public function reward_ad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_advertisements' => 'required',
            'id_watchAdvertisementsLog' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $user = Auth::user();
            $user_id = $user->id;
            $advertisements = Advertisement::find($request->id_advertisements);
            $watchAdvertisementsLog = WatchAdvertisementsLog::find($request->id_watchAdvertisementsLog);
            if($watchAdvertisementsLog->status !== config('apps.common.status_watch_ad.pending')){
                return $this->sendError(
                    "You have not watched the video",
                    ['error' => trans('translation.you_have_not_watched_the_video')]
                );
            }
            $time_before_watch_video = $watchAdvertisementsLog->created_at;
            $time = strtotime(date('Y-m-d h:i:sa')) - strtotime($time_before_watch_video);
            $advertisementsSettings  =  AdvertisementsSettings::where('user_id', $user_id)->first();
            $error_popup = AdvertisementService::postMessagePopup($user_id);
            if ($error_popup['status']) {
                return $this->sendResponse(new AdvertisementResource($advertisements), $error_popup);
            }
            if($time > $advertisements->time){
                    if (!empty($advertisements)) {
                        $productInventory  = ProductInventory::where('id', $advertisementsSettings->product_inventory_id)->first();
                        $productInventory->durability =  $productInventory->durability - config('apps.common.mining_value_reduce');
                        $productInventory->save();
                        $productInventory  =  $advertisementsSettings->product_inventory;
                        $kindGlasses = $productInventory->glass_type;
                        $listGlass = config('apps.common.glass_category');
                        $durability = $productInventory->durability;
                            foreach ($listGlass as $key => $value) {
                                if ($value === $kindGlasses) {
                                    $kindGlasses = config('apps.common.glass_type.' . $key);
                                    break;
                                }
                            }
        
                        if ($advertisements->mining_settings == config('apps.common.mining_settings.auto')) {
                            $ad_value = config('apps.common.advertising_value');
                        } else {
                            $ad_value = $advertisements->rewards;
                        }
                        $level = ($productInventory->level - 1) * 0.05;
                        $durability = 100 -  $durability;
                        $durability = $durability / 0.2 * 2;
                        $durability = $durability / 100 ;
                        $amountMining = ((10 - $durability) * $kindGlasses * (1 + $level)) * $ad_value;
                        $watchAdvertisementsLog->time =  $advertisements->time;
                        $watchAdvertisementsLog->rewards =   $amountMining;
                        $watchAdvertisementsLog->cumulative_mining =   $amountMining;
                        $watchAdvertisementsLog->status =  config('apps.common.status_watch_ad.complete');
                        $watchAdvertisementsLog->product_inventory_id = $advertisementsSettings->product_inventory_id;
                        $watchAdvertisementsLog->save();
                        $success['amountMining'] = $amountMining ." BST ";
                        $success['watchAdvertisementsLog']  = $watchAdvertisementsLog;
                        return $this->sendResponse($success, 'The reward of advertising ');
                    }
            }else{
                $watchAdvertisementsLog->time =  $advertisements->time;
                $watchAdvertisementsLog->product_inventory_id = $advertisementsSettings->product_inventory_id;
                $watchAdvertisementsLog->save();
                return $this->sendResponse('', "You haven't watched all the videos ");
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError(
                "Please, recalculate the mining value",
                ['error' => trans('translation.Recalculate_the_mining_value')]
            );
        }
    }

    public function sum_reward()
    {
        $user = Auth::user();
        $user_id = $user->id;
        $watchAdvertisements  = $user->watchAdvertisements;
        $sum_rewards = 0;
        if(count($watchAdvertisements)){
            $watchAdvertisements_paid = $watchAdvertisements->filter(function ($watchAdvertisement, $key) {
                return $watchAdvertisement->rewards > 0 ;
            });
            $sum_rewards = $watchAdvertisements_paid->sum('rewards');
        }
        $data = ['rewards' => $sum_rewards ." BST "];
        return $this->sendResponse($data, 'Here is all reward from watched advertisement');
    }

    public function confirm_get_reward(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'get' => 'required|boolean',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = Auth::user();
        $user_id = $user->id;
        $watchAdvertisements  = $user->watchAdvertisements;
        $sum_rewards = 0;
        if(!count($watchAdvertisements)){
            $data = ['rewards' => $sum_rewards ." BST "];
            return $this->sendResponse($data, 'Here is all reward from watched advertisement');
        }else{
            if($request->get){
                $watchAdvertisements_paid = $watchAdvertisements->filter(function ($watchAdvertisement, $key) {
                    return $watchAdvertisement->rewards > 0 ;
                });
                if(!count($watchAdvertisements_paid)){
                    $data = ['rewards' => $sum_rewards ." BST "];
                    return $this->sendResponse($data, 'you have no reward to receive');
                }
                $sum_rewards =  $watchAdvertisements_paid->sum('rewards');
                $array_coin = [
                    config('apps.common.coin_id.MATIC') => 0,
                    config('apps.common.coin_id.BMT') => 0,
                    config('apps.common.coin_id.BST') => $sum_rewards,
                ];

                $takeReward =  WalletService::getReward($array_coin, $user_id);
                if(!$takeReward['status']){
                    return $this->sendResponse($takeReward, "Sorry you can't get the error successfully");
                }
                foreach($watchAdvertisements_paid as $watchAdvertisement){
                    $watchAdvertisement->rewards =  0;
                    $watchAdvertisement->save(); 
                }
                $wallet = UserWallet::where('user_id', $user_id)
                ->where('coin_id', config('apps.common.coin_id.BST'))->where('status', config('apps.common.status_wallet.activate'))->first();
                return $this->sendResponse($wallet , "Get reward successfully ");
            }else{
                return $this->sendResponse(['message' =>  trans('translation.Success')], trans('translation.Success'));
            } 
         
        }
    }

    function toHMS($seconds) {
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
    }

    function information_setting_ad(){
        $user = Auth::user();
        $setting =  AdvertisementsSettings::where('user_id',$user->id)->first();
        if($setting){
            return $this->sendResponse(new AdvertisementsSettingsResource($setting), 'Information product inventory success');
        }
        return $this->sendResponse([], 'Not yet ads setting');
    }
}
