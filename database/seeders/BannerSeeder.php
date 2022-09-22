<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i <5;$i++){
            $banner = new Banner();
            $banner->name = $faker->name;
            $banner->date_end =  '2023/10/11';
            $banner->date_start =  $faker->date('y-m-d', 'now');
            $banner->status = rand(0,1);
            $banner->save();
        }
    }
}
