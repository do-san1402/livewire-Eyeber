<?php

namespace Database\Seeders;

use App\Models\QA;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class QASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i= 0;$i<20 ; $i++){
            $qa =  new QA();
            $qa->name = $faker->name;
            $qa->registration_date = $faker->date('y-m-d');
            $qa->description =  $faker->name;
            $qa->status =  rand(0,1);
            $qa->save();    
        }
    }
}
