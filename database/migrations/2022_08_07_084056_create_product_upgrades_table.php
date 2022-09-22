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
        Schema::create('product_upgrades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->float('bmt');
            $table->float('bst');
            $table->float('durability');
            $table->float('mining');
            $table->BigInteger('level');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('product_upgrades');
    }
};
