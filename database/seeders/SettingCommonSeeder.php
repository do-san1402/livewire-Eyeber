<?php

namespace Database\Seeders;

use App\Models\Coin;
use App\Models\SettingCommon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingCommonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new SettingCommon();
        $setting->key = 'convert';
        $setting->value = '{"coin_exchange": 1,"rate": 15,"coin_receive" : 3}';
        $setting->save();
        $setting = new SettingCommon();
        $setting->key = 'convert';
        $setting->value = '{"coin_exchange": 1,"rate": 15,"coin_receive" : 2}';
        $setting->save();
        $setting = new SettingCommon();
        $setting->key = 'convert';
        $setting->value = '{"coin_exchange": 2,"rate": 15,"coin_receive" : 1}';
        $setting->save();
        $setting = new SettingCommon();
        $setting->key = 'convert';
        $setting->value = '{"coin_exchange": 2,"rate": 15,"coin_receive" : 3}';
        $setting->save();
        $setting = new SettingCommon();
        $setting->key = 'convert';
        $setting->value = '{"coin_exchange": 3,"rate": 15,"coin_receive" : 1}';
        $setting->save();
        $setting = new SettingCommon();
        $setting->key = 'convert';
        $setting->value = '{"coin_exchange": 3,"rate": 15,"coin_receive" : 2}';
        $setting->save();
        $coins = Coin::all();
        foreach($coins as $coin){
            $setting = new SettingCommon();
            $setting->key = 'min_'. $coin->id;
            $setting->value = 100;
            $setting->save();
        }
        
    }
}
