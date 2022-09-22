<?php

namespace Database\Seeders;

use App\Models\Nation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nation =  new Nation();
        $nation->name = '대한민국';
        $nation->save();
        $nation =  new Nation();
        $nation->name = '미국';
        $nation->save();
        $nation =  new Nation();
        $nation->name = '인도';
        $nation->save();
        $nation =  new Nation();
        $nation->name = '베트남';
        $nation->save();
        $nation =  new Nation();
        $nation->name = '중국';
        $nation->save();
        $nation =  new Nation();
        $nation->name = '일본';
        $nation->save();
        $nation =  new Nation();
        $nation->name = '기타';
        $nation->save();
        
    }
}
