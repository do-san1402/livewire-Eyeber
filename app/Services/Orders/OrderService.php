<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderDetail;

class OrderService{

    public static function createTransaction($user_id,$array_coin, $product_id, $cateogry_order_id)
    {
        $order = new Order();
        $coin_sum = 0;
        foreach($array_coin as $key => $coin){
            $coin_sum = $coin_sum + $coin;
        }

        $order->product_purchase_date = date('Y-m-d');
        $order->user_id = $user_id;
        $order->category_id = $cateogry_order_id;
        $order->status_id = config('apps.common.status_order.completion');
        $order->method_of_payment = config('apps.common.available_coins.polygon');
        $order->amount_of_payment =  $coin_sum ;
        $order->cancellation_processing = config('apps.common.cancellation.continue');
        $order->save();
        $order_id = $order->id;
        
        $order_detail = new OrderDetail();
        $order_detail->product_id  = $product_id;
        $order_detail->money_bmt   = $array_coin[config('apps.common.coin_id.BMT')] ?? 0;
        $order_detail->money_bst   = $array_coin[config('apps.common.coin_id.BST')] ?? 0;
        $order_detail->money_matic = $array_coin[config('apps.common.coin_id.MATIC')] ?? 0;
        $order_detail->order_id    = $order_id;
        $order_detail->save();
        return $order_id;
    }

    
}