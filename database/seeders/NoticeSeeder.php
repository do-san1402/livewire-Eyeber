<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i= 0;$i<10 ; $i++){
            $notice =  new Notice();
            $notice->title = $faker->name;
            $notice->registration_date = $faker->date('y-m-d');
            $notice->views = $faker->randomNumber(4);
            $notice->ad_status_id = 0;
            $notice->content =  $faker->name;
            $notice->save();
            $notice =  new Notice();
            $notice->title = $faker->name;
            $notice->registration_date = $faker->date('y-m-d');
            $notice->views = $faker->randomNumber(4);
            $notice->ad_status_id =  1;
            $notice->content =  $faker->name;
            $notice->save();
        }
    }
}
