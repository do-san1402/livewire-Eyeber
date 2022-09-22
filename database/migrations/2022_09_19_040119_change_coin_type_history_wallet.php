<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet_address_historys', function (Blueprint $table) {
            $table->float('coin_bmt')->change();
            $table->float('coin_matic')->change();
            $table->float('coin_bst')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_address_historys', function (Blueprint $table) {
            $table->float('coin_bmt')->change();
            $table->float('coin_matic')->change();
            $table->float('coin_bst')->change();
        });
    }
};
