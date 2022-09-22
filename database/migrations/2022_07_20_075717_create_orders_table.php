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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->date('product_purchase_date');
            $table->unsignedBigInteger('user_id');
            $table->integer('category_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('status_id');
            $table->integer('method_of_payment');
            $table->integer('amount_of_payment');
            $table->integer('cancellation_processing');
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
        Schema::dropIfExists('orders');
    }
};
