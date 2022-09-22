<?php

namespace App\Http\Controllers\Api\ProductInventorys;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\PaginateResource;
use App\Http\Resource\ProductInventoryResource;
use App\Models\AdvertisementsSettings;
use App\Models\Coin;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductUpgrade;
use App\Models\SendProductLog;
use App\Models\User;
use App\Services\FirebaseService;
use App\Services\Orders\OrderService;
use App\Services\ProductInventorys\ProductInventoryService;
use App\Services\Wallets\WalletService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductInventoryController extends BaseController
{
    const paginate_size = 4;
    
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'can_use' => 'nullable|boolean',
            'level' => 'nullable|boolean',
            'durability' => 'nullable|boolean',
            'most_recently_purchase'  => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $paginate_size =  $request->paginate_size ?? self::paginate_size;
        $request = $request->all();
        $products = new ProductInventory();
        if(isset($request['level'])){
            if($request['level']){
                $products =   $products->orderBy('level', 'DESC');
            }
        }
        if(isset($request['durability'])){
            if($request['durability']){
                $products = $products->orderBy('durability', 'DESC');
            }
        }
        if(isset($request['most_recently_purchase'])){
            if($request['most_recently_purchase']){
                $products = $products->orderBy('created_at', 'DESC');
            }
        }
        $user = Auth::user();
        if (isset($request['can_use'])) {
            $can_use = $request['can_use'];
            if ($can_use) {
                $products = $products->with(['product'])->where('user_id', $user->id)->where('durability', '>', 0);
            } else {
                $products = $products->with(['product'])->where('user_id', $user->id)->where('durability', 0);
            }
        } else {
            $products = $products->with(['product'])->where('user_id', $user->id);
        }
        $products = $products->paginate($paginate_size);

        return $this->sendResponse(new PaginateResource($products), 'Product Inventory list success');
    }

    public function detail($id)
    {
        $product_inventory_detail = ProductInventory::find($id);
        return $this->sendResponse(new ProductInventoryResource($product_inventory_detail),'Product inventory detail success');
    }

    public function price_upgrade($id)
    {
        $product_inventory = ProductInventory::find($id);
        if($product_inventory->level === 1 ){
            $product_upgrade = ProductUpgrade::where('product_id', $product_inventory->product_id)
            ->where('level', $product_inventory->level + 1)->first();
        }else{
            $product_upgrade = ProductUpgrade::where('product_id', $product_inventory->product_id)
            ->where('level', $product_inventory->level)->first();
        }
        if($product_inventory->level >= 30 ){
            $product_upgrade = new ProductUpgrade();
            $product_upgrade->bmt = 0; 
            $product_upgrade->bst = 0; 
            $product_upgrade->durability = 0.1; 
            $product_upgrade->mining = 0.12; 
            return $this->sendResponse($product_upgrade, 'Your level has reached the highest ');
        }
        if(!$product_upgrade){
            $bmt = $product_inventory->level / 2;
            $bst = $bmt * 5;
            $durability = 0.1;
            $mining = 0.12;
            $product_upgrade = new ProductUpgrade();
            $product_upgrade->bmt = $bmt; 
            $product_upgrade->bst = $bst; 
            $product_upgrade->durability = $durability; 
            $product_upgrade->mining = $mining; 
        }
        return $this->sendResponse($product_upgrade, 'price upgrade');
    }

    public function repair(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_inventory_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            // hard code caculator repair fees product inventory
            $repair_fees = ProductInventoryService::repair_fees($request->product_inventory_id);

            $user = Auth::user();
            $user_id = $user->id;
            $array_coin = [];
            foreach($repair_fees as $coin_id => $coins){
                $array_coin[$coin_id] = $coins['amount'];
            }

            $product_inventory_id = $request->product_inventory_id;
            $product_inventory = ProductInventory::find($product_inventory_id);
            if(!$product_inventory){
                return $this->sendError('Repair fail', ['error' => trans('translation.Repair_fail')]);
            }
            $wallet_service = WalletService::coinCharge($user_id,$array_coin);
            if(!$wallet_service['status']){
                return $this->sendError($wallet_service['message'], ['error' => $wallet_service['error']]);
            }
        
            $cateogry_order_id = config('apps.common.category_order.repair');
            $orders_service = OrderService::createTransaction($user_id ,$array_coin,  $product_inventory->product_id, $cateogry_order_id);
            // repair durability 100
            $durability = config('apps.common.durability');
            $productInventoryservice = ProductInventoryService::upgrade($product_inventory_id, $product_inventory->level,  $durability);
          
            return $this->sendResponse($productInventoryservice, 'Repair Success');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('Repair fail', ['error' => trans('translation.Repair_fail')]);
        }
    }

    public function upgrade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_inventory_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $user = Auth::user();
            $product_inventory = ProductInventory::find($request->product_inventory_id);
            if($product_inventory->level === 1 ){
                $product_upgrade = ProductUpgrade::where('product_id', $product_inventory->product_id)
                ->where('level', $product_inventory->level + 1)->first();
            }else{
                $product_upgrade = ProductUpgrade::where('product_id', $product_inventory->product_id)
                ->where('level', $product_inventory->level)->first();
            }
            if($product_inventory->level >= 30 ){
                $product_upgrade = new ProductUpgrade();
                $product_upgrade->bmt = 0; 
                $product_upgrade->bst = 0; 
                $product_upgrade->durability = 0; 
                $product_upgrade->mining = 0; 
                return $this->sendResponse($product_upgrade, 'Your level has reached the highest ');
            }
            if(!$product_upgrade){
               
                $bmt = $product_inventory->level / 2;
                $bst = $bmt * 5;
                $durability = 0.1;
                $mining = 0.12;
                $product_upgrade = new ProductUpgrade();
                $product_upgrade->bmt = $bmt; 
                $product_upgrade->bst = $bst; 
                $product_upgrade->durability = $durability; 
                $product_upgrade->mining = $mining; 
            }
            $array_coin = [
                config('apps.common.coin_id.MATIC') =>  0,
                config('apps.common.coin_id.BMT') =>  $product_upgrade->bmt,
                config('apps.common.coin_id.BST') => $product_upgrade->bst,
            ];

            $wallet_service = WalletService::coinCharge($user->id,$array_coin);
            if(!$wallet_service['status']){
                return $this->sendError($wallet_service['message'], ['error' => $wallet_service['error']]);
            }
            $cateogry_order_id = config('apps.common.category_order.upgrade');

            $orders_service = OrderService::createTransaction($user->id ,$array_coin,  $product_inventory->product_id, $cateogry_order_id);
            // upgrade product inventory update level
            $level = $product_inventory->level + 1;
            $productInventoryservice = ProductInventoryService::upgrade($request->product_inventory_id, $level,  $product_inventory->durability);

            return $this->sendResponse($productInventoryservice, 'Upgrade Success');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('Upgrade fail', ['error' => trans('translation.Upgrade_fail')]);
        }
    }

    public function repair_fees($id)
    {
        // hard code caculator repair fees product inventory
        $repair_fees = ProductInventoryService::repair_fees($id);
        return $this->sendResponse(['repair_fees' => $repair_fees], 'Upgrade Success');
    }

    public function giveProduct(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'product_inventory_id' => 'required',
                'user_receive' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $product_inventory_id =  $request->product_inventory_id;
            $user_receive =  $request->user_receive;
            $userAuth = Auth::user();
            $product_inventory = ProductInventory::where('user_id', $userAuth->id)->where("id", $product_inventory_id)->first();
            $setting_ad = AdvertisementsSettings::where('product_inventory_id', $product_inventory_id)->first();
            if($setting_ad){
                $data = [
                    'status' => 1,
                    'message' => trans('translation.Your_product_is_already_installed_in_the_ad_Please_change_the_setting_to_a_different_product')
                ];
                return $this->sendResponse($data, 'Your product is already installed in the ad. Please change the setting to a different product.');
            }
            if(!$product_inventory){
                return $this->sendError(
                    "You did not choose your product in inventory correctly",
                    ['error' => trans('translation.You_did_not_choose_your_inventory_correctly')]
                );
            }

            $user =  User::find($user_receive);
            if(!$user){
                return $this->sendError('Does not user exist.', ['error' => 'Does not user exist']);
            }
            $product_inventory =  ProductInventory::find($product_inventory_id);
            $product_inventory->user_id = $user_receive;
            $product_inventory->save();
            $sendProductLog = new SendProductLog();
            $sendProductLog->user_receive = $user_receive;
            $sendProductLog->user_give = $userAuth->id;
            $sendProductLog->product_inventory_id = $product_inventory_id;
            $sendProductLog->save();

            // Push notice for user receive  
            if($user->device_token){
                $device_token =  $user->device_token;
                $notice    = [
                    'title' => trans('translation.your_gift'),
                    'body'  => trans('translation.send_product_gift', ['user' => $user->full_name , 'gift' =>  $product_inventory->product_inventory_name ])
                ];
                $data = [ 
                    'user_give' => $userAuth->id,
                    'message'   => trans('translation.send_product_gift', ['user' => $user->full_name , 'gift' =>  $product_inventory->product_inventory_name ]),
                    'title' => trans('translation.your_gift'),
                    'product_inventory_id' => $product_inventory->id
                ];
                FirebaseService::sendMessaging($device_token, $notice, $data);
            }

            $data = [];
            $data['send_product_log'] = $sendProductLog;
            $data['product_inventory'] = $product_inventory;

            return $this->sendResponse($data, 'Give product success');
        }catch (Exception $e) {
            Log::error($e->getMessage());

            return $this->sendError('Give product fail', ['error' => trans('translation.Give_product_fail')]);
        }
    }

}
