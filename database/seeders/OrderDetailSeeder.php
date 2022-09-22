<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderDetail;
use Faker\Generator as Faker;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 1; $i <51;$i++){
            $order = new OrderDetail();
            $order->product_id = rand(1,9);  
            $order->money_bmt =  $faker->randomNumber(2);
            $order->money_bst =  $faker->randomNumber(2);
            $order->money_matic =  $faker->randomNumber(2); 
            $order->order_id = $i;
            $order->save();
        } 
    }
}


