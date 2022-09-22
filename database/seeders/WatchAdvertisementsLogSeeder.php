<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\WatchAdvertisementsLog;

class WatchAdvertisementsLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i= 0;$i<50 ; $i++){
            $watchAdvertisementsLog =  new WatchAdvertisementsLog();
            $watchAdvertisementsLog->product_inventory_id = rand(1, 10);
            $watchAdvertisementsLog->advertisement_id = rand(1, 10) ;
            $watchAdvertisementsLog->view = rand(1, 1000);
            $watchAdvertisementsLog->cumulative_mining = rand(1, 1000);
            $watchAdvertisementsLog->time = rand(1, 100);
            $watchAdvertisementsLog->view = rand(1, 100);
            $watchAdvertisementsLog->status = rand(0,1);
            $watchAdvertisementsLog->user_id = rand(1,5);
            $watchAdvertisementsLog->save();
        }
    }
}
