<?php

namespace Database\Seeders;

use App\Models\Coin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
            $coin = new Coin();
            $coin->symbol_name = "MATIC";
            $coin->name = "Polygon";
            $coin->admin_wallet_id = 1;
            $coin->save();
            $coin = new Coin();
            $coin->symbol_name = "BMT";
            $coin->name = "BMT";
            $coin->admin_wallet_id = 2;
            $coin->save();
            $coin = new Coin();
            $coin->symbol_name = "BST";
            $coin->name = "BST";
            $coin->admin_wallet_id = 3;
            $coin->save();
    }
}
