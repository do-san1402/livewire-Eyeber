<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i =0 ;$i<10 ;$i++){
            $advertis = new Advertisement();
            $advertis->name = $faker->name;    
            $advertis->description = $faker->name;    
            $advertis->date = $faker->date('y-m-d');    
            $advertis->date_end = '2025-11-06';    
            $advertis->date_start = $faker->date('y-m-d');    
            $advertis->views = $faker->randomNumber(3);    
            $advertis->mining_settings = $faker->randomNumber(1);    
            $advertis->rewards = $faker->randomNumber(3);    
            $advertis->ad_status_id = 0;    
            $advertis->set_collection_deduction = $faker->randomNumber(1);   
            $advertis->nation_id = '["1", "2", "3", "4", "5", "6", "7"]';
            $advertis->save();
            $advertis = new Advertisement();
            $advertis->name = $faker->name;    
            $advertis->description = $faker->name;    
            $advertis->date = $faker->date('y-m-d');    
            $advertis->date_end = '2025-11-06';    
            $advertis->date_start = $faker->date('y-m-d');    
            $advertis->views = $faker->randomNumber(3);    
            $advertis->mining_settings = $faker->randomNumber(1);    
            $advertis->rewards = $faker->randomNumber(3);    
            $advertis->ad_status_id = 1;    
            $advertis->set_collection_deduction = $faker->randomNumber(1);   
            $advertis->nation_id = '["1", "2", "3", "4", "5", "6", "7"]';
            $advertis->save();
        }    
    }
}
