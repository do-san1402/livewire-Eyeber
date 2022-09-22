<?php

namespace Database\Seeders;

use App\Models\JoiningForm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JoiningFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nation =  new JoiningForm();
        $nation->name = 'normally';
        $nation->save();
        $nation =  new JoiningForm();
        $nation->name = 'SNS(instagram)';
        $nation->save();
    }
}
