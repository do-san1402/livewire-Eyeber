<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rank  = new Rank();
        $rank->name = '통합';
        $rank->save();
        $rank  = new Rank();
        $rank->name = '중간';
        $rank->save();
        $rank  = new Rank();
        $rank->name = '일반';
        $rank->save();
    }
}
