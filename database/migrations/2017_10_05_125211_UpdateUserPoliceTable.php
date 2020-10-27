<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserPoliceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_police', function (Blueprint $table) {
            $table->integer('user_id', false, true)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->integer('police_id', false, true)->nullable();
            $table->foreign('police_id')->references('id')->on('polices')->onDelete('SET NULL');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_police', function (Blueprint $table) {
            //
        });
    }
}
