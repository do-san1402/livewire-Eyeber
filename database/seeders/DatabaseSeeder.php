<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(JoiningFormSeeder::class);
        $this->call(NationSeeder::class);
        $this->call(RankSeeder::class);
        $this->call(AdvertisementSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(NoticeSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(ProductInventorySeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(AlertSeeder::class);
        $this->call(OrderDetailSeeder::class);
        $this->call(CoinSeeder::class);
        $this->call(UserWalletSeeder::class);
        $this->call(AdminWalletSeeder::class);
        $this->call(WatchAdvertisementsLogSeeder::class);
        $this->call(CoinLogSeeder::class);
        $this->call(QASeeder::class);
        $this->call(SettingCommonSeeder::class);
    }
}
