<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i <50;$i++){
            $order = new Order();
            $order->product_purchase_date = '2022-'.'0'.rand(1,8).'-'.rand(1,27);
            $order->user_id = rand(1,7);  
            $order->category_id = rand(1,2); 
            $order->status_id = rand(0,2);  
            $order->method_of_payment = rand(0,2);
            $order->amount_of_payment = $faker->randomNumber(4);
            $order->cancellation_processing = rand(0,1);
            $order->save();
        }
    }
}
