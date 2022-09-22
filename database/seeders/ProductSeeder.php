<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       $product = new Product();
       $product->available_coins_id = config('apps.common.available_coins.polygon');
       $product->name = $faker->name;
       $product->durability = $faker->randomNumber(1);
       $product->of_mining = $faker->randomNumber(2);
       $product->description = $faker->name;
       $product->price_matic = $faker->randomNumber(2);
       $product->level = $faker->randomNumber(2);
       $product->glass_type = 1;
       $product->sale_status_id = config('apps.common.status_sales.Sale');
       $product->image = Str::random(20);
       $product->repair_cost = config('apps.common.repair_cost.Direct_setting');
       $product->mining =  0.5;
       $product->save();
       $product = new Product();
       $product->available_coins_id = config('apps.common.available_coins.polygon');
       $product->name = $faker->name;
       $product->description = $faker->name;
       $product->of_mining = $faker->randomNumber(2);
       $product->durability = $faker->randomNumber(1);
       $product->price_matic = $faker->randomNumber(2);
       $product->level = $faker->randomNumber(2);
       $product->glass_type = 1;
       $product->sale_status_id = config('apps.common.status_sales.Stop_selling');
       $product->image = Str::random(20);
       $product->repair_cost = config('apps.common.repair_cost.Auto_setup');
       $product->mining =  1.5;
       $product->save();
       $product = new Product();
       $product->available_coins_id = config('apps.common.available_coins.cash_krw');
       $product->name = $faker->name;
       $product->durability = $faker->randomNumber(1);
       $product->durability_used = $faker->randomNumber(2);
       $product->description = $faker->name;
       $product->price_matic = $faker->randomNumber(2);
       $product->level = $faker->randomNumber(2);
       $product->glass_type = 4;
       $product->sale_status_id = config('apps.common.status_sales.Stop_selling');
       $product->repair_cost = config('apps.common.repair_cost.Auto_setup');
       $product->image = Str::random(20);
       $product->mining =  2.5;
       $product->save();
       $product = new Product();
       $product->name = $faker->name;
       $product->available_coins_id = config('apps.common.available_coins.cash_dollars');
       $product->durability = $faker->randomNumber(1);
       $product->durability_used = $faker->randomNumber(2);
       $product->description = $faker->name;
       $product->price_matic = $faker->randomNumber(2);
       $product->level = $faker->randomNumber(2);
       $product->glass_type = 1;
       $product->sale_status_id = config('apps.common.status_sales.Stop_selling');
       $product->repair_cost = config('apps.common.repair_cost.Direct_setting');
       $product->image = Str::random(20);
       $product->mining =  1.5;
       $product->save();
       $product = new Product();
       $product->name = $faker->name;
       $product->available_coins_id = config('apps.common.available_coins.cash_dollars');
       $product->durability_used = $faker->randomNumber(2);
       $product->durability = $faker->randomNumber(1);
       $product->description = $faker->name;
       $product->price_matic = $faker->randomNumber(2);
       $product->level = $faker->randomNumber(2);
       $product->repair_cost = config('apps.common.repair_cost.Direct_setting');
       $product->glass_type = 3;
       $product->sale_status_id = config('apps.common.status_sales.Unexposed');
       $product->image = Str::random(20);
       $product->mining = $faker->latitude;
       $product->save();
       for($i =0; $i <10; $i++){
            $product = new Product();
            $product->mining = $faker->latitude;
            $product->name = $faker->name;
            $product->available_coins_id = config('apps.common.available_coins.cash_dollars');
            $product->durability_used = $faker->randomNumber(2);
            $product->durability = 100;
            $product->description = $faker->name;
            $product->price_matic = $faker->randomNumber(2);
            $product->level = $faker->randomNumber(2);
            $product->repair_cost = config('apps.common.repair_cost.Direct_setting');
            $product->glass_type = 2;
            $product->sale_status_id = config('apps.common.status_sales.Sale');
            $product->image = Str::random(20);
            $product->save();
        }
    }
}
