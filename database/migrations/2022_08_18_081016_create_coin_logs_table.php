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
        Schema::create('coin_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('status_classification_coin');
            $table->date('date_start');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('coin_id');
            $table->integer('status_log_coin');
            $table->date('date_end');
            $table->integer('amount');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coin_logs');
    }
};
