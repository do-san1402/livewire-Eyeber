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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('price_matic');
            $table->integer('price_krw');
            $table->integer('price_usd');
            $table->integer('level');
            $table->float('mining');
            $table->integer('durability');
            $table->unsignedBigInteger('sale_status_id');
            $table->integer('product_upgrade');
            $table->integer('repair_cost');
            $table->integer('of_mining')->nullable();
            $table->integer('durability_used')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->integer('available_coins_id');
            $table->integer('decrease')->nullable();
            $table->integer('mining_amount_when_decreasing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
