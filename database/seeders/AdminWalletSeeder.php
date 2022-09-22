<?php

namespace Database\Seeders;

use App\Models\AdminWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class AdminWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user_wallet = new AdminWallet();
        $user_wallet->amount =  $faker->randomNumber(4);
        $user_wallet->address =  Str::random(30);
        $user_wallet->status =  rand(0,1);
        $user_wallet->admin_id =  6;
        $user_wallet->save();
        $user_wallet = new AdminWallet();
        $user_wallet->amount =  $faker->randomNumber(4);
        $user_wallet->address =  Str::random(30);
        $user_wallet->status =  rand(0,1);
        $user_wallet->admin_id =  7;
        $user_wallet->save();
        $user_wallet = new AdminWallet();
        $user_wallet->amount =  $faker->randomNumber(4);
        $user_wallet->address =  Str::random(30);
        $user_wallet->status =  rand(0,1);
        $user_wallet->admin_id =  8;
        $user_wallet->save();
    }
}
