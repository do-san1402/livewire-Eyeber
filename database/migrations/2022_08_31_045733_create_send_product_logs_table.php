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
        Schema::create('send_product_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_receive');
            $table->unsignedBigInteger('user_give');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_inventory_id');
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
        Schema::dropIfExists('send_product_logs');
    }
};
