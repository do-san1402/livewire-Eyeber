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
        Schema::table('watch_advertisements_log', function (Blueprint $table) {
            $table->float('cumulative_mining')->change();
            $table->float('rewards')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('watch_advertisements_log', function (Blueprint $table) {
            $table->dropColumn('cumulative_mining')->change();
            $table->dropColumn('rewards')->change();
        });
    }
};
