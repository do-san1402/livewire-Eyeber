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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->date('date');
            $table->date('date_end');
            $table->date('date_start');
            $table->integer('views');
            $table->integer('mining_settings');
            $table->integer('rewards');
            $table->integer('ad_status_id');
            $table->integer('set_collection_deduction');
            $table->integer('nation_id');
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
        Schema::dropIfExists('advertisements');
    }
};
