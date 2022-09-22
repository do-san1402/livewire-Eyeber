<?php

namespace Database\Seeders;

use App\Models\CoinLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CoinLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20 ;$i++){
            $coinLog = new CoinLog();
            $coinLog->status_classification_coin = rand(0,1);
            $coinLog->date_start =  '2022-'.rand(1,8).'-'.rand(1,27);
            $coinLog->user_id = rand(1,5);
            $coinLog->coin_id = rand(1,3);
            $coinLog->status_log_coin = rand(0,4);
            $coinLog->date_end = date('Y-m-d');
            $coinLog->amount = rand(1000,10000);
            $coinLog->address = Str::random(50);
            $coinLog->save();
        }
        
    }
}
