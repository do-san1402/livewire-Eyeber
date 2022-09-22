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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nick_name');
            $table->string('number_phone');
            $table->unsignedBigInteger('rank_id');
            $table->string('full_name');
            $table->unsignedBigInteger('nation_id');
            $table->integer('gender');
            $table->integer('age');
            $table->integer('role_type')->default(1);
            $table->date('date_of_joining');
            $table->date('birthday')->format('yy/mm/dd');
            $table->unsignedBigInteger('status_user_id');
            $table->unsignedBigInteger('joining_form_id');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
