<?php

namespace Database\Seeders;

use App\Models\UserWallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UserWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0 ; $i<10 ;$i++){
            $user_wallet = new UserWallet();
            $user_wallet->amount =  $faker->randomNumber(4);
            $user_wallet->address =  Str::random(30);
            $user_wallet->status =  rand(0,1);
            $user_wallet->user_id =  rand(1,5);
            $user_wallet->coin_id =  rand(1,3);
            $user_wallet->save();
        }
       
    }
}
