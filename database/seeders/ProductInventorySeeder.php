<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\SettingCommon;
use App\Services\Glass\GlassService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
            for($i = 0; $i <10;$i++){
                $glass_type = rand(0,4);
                $product_id = rand(1,10);
                $level = rand(1,10);
                $productInventory = new ProductInventory();
                $productInventory->product_id = $product_id;  
                $productInventory->user_id = rand(1,5);  
                $productInventory->durability =   $level;
                $productInventory->level = $faker->randomNumber(1);
                $productInventory->glass_type = $glass_type;
                $product = Product::find($product_id);
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
                    $setting_common->value = (int)$setting_common->value + 1;
                    $setting_common->save();
                }
                $stone = config('apps.common.glass_category.stone');
                if((int) $product->glass_type === $stone ){
                    $glass_make_serial  =  GlassService::makeSerialNumber($glass, $setting_common->value, $stone);
                }else{
                    $glass_make_serial  =  GlassService::makeSerialNumber($glass, $setting_common->value);
                }
                $productInventory->serial_number_glass = $glass_make_serial;
                $productInventory->save();
            }
    }
}
