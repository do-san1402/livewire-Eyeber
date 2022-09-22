<?php

namespace Database\Seeders;

use App\Models\Alert;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i <5;$i++){
            $alert = new Alert();
            $alert->name = $faker->name;
            $alert->date_end =  '2023/10/11';
            $alert->date_start =  $faker->date('y-m-d', 'now');
            $alert->status = rand(0,1);
            $alert->save();
        }
    }
}
