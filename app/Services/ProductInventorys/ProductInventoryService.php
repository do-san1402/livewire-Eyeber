<?php

namespace App\Services\ProductInventorys;

use App\Models\Coin;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\SettingCommon;
use App\Services\Glass\GlassService;

class ProductInventoryService{

    public static function upgrade($product_inventory_id, $level, $durability)
    {
        $product_inventory =  ProductInventory::find($product_inventory_id);
        $product_inventory->level = $level;
        $product_inventory->durability = $durability;
        $product_inventory->save();
        return $product_inventory;   
    }
    
    public static function create($product_id, $user_id)
    {
        $product_inventory = new ProductInventory();
        $product = Product::find($product_id);
        $product_inventory->product_id = $product_id;
        $product_inventory->user_id = $user_id;
        $product_inventory->durability = config('apps.common.durability');
        $product_inventory->level =  config('apps.common.level_coin');
        $product_inventory->glass_type =  $product->glass_type;
       
        $glass_category =  config('apps.common.glass_category');
        $glass = '';
        foreach($glass_category as $key => $glass){
            if( (int)$product->glass_type === $glass){
                $glass =  $key;
                break;
            }
        }
        $setting_common =  SettingCommon::where('key', $glass)->first();
        if(!$setting_common){
            $setting_common = new SettingCommon();
            $setting_common->key = $glass;
            $setting_common->value = 1;
            $setting_common->save();
        }else{
            $setting_common->key = $glass;
            $setting_common->value = (int)$setting_common->value + 1;
            $setting_common->save();
        }
        $stone = config('apps.common.glass_category.stone');
        if((int) $product->glass_type === $stone ){
            $glass_make_serial  =  GlassService::makeSerialNumber($glass, $setting_common->value, $stone);
        }else{
            $glass_make_serial  =  GlassService::makeSerialNumber($glass, $setting_common->value);
        }
        $product_inventory->serial_number_glass = $glass_make_serial;
        $product_inventory->save();
        return  $product_inventory;
    }

    public static function repair_fees($id)
    {
        $durability_formula_glass = config('apps.common.durability_formula_glass');
        $product_inventory = ProductInventory::find($id);
        if(!$product_inventory){
            return false;
        }
        
        $durability = $product_inventory->durability;
        $percent = 100 - $durability;
        $data = [];
        $coins = [];
        foreach($durability_formula_glass as $glass => $coin){
            if($glass === $product_inventory->glass_type){
                $coins = $coin;
                break;
            }
        }
        foreach($coins as $key => $amount){
            $coin = Coin::find($key);
            $data[$key] =  [
                'unit' => $coin->symbol_name,
                'amount' => $amount * $percent,
            ];
        }
        return $data; // caculator repair fees product inventory
    }
}