<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductUpgrade;
use App\Services\Orders\OrderService;
use App\Services\ProductInventorys\ProductInventoryService;
use App\Services\Wallets\WalletService;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends BaseController
{
    public function buy_product(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = Auth::user();
            $user_id = $user->id;
            
            $product_id = $request->product_id;
            $product = Product::where('id', $product_id)->first();
            if(!$product){
                return $this->sendError('Buy product error', ['error' => trans('translation.Buy_product_error')]);
            }
            
            $array_coin = [
              config('apps.common.coin_id.MATIC') => $product->price_matic,
              config('apps.common.coin_id.BMT') => 0,
              config('apps.common.coin_id.BST') => 0,
            ];
            
            $wallet_service = WalletService::coinCharge($user_id,$array_coin);
            if(!$wallet_service['status']){
                return $this->sendError($wallet_service['message'], ['error' => $wallet_service['error']]);
            }

            $cateogry_order_id = config('apps.common.category_order.purchase');
            $orders_service = OrderService::createTransaction($user_id ,$array_coin, $product->id, $cateogry_order_id);
            $productInventoryservice = ProductInventoryService::create($product_id, $user_id);
          
            return $this->sendResponse($productInventoryservice, 'Buy product success');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->sendError('Buy product error', ['error' => trans('translation.Buy_product_error')]);
        }
    }
}
