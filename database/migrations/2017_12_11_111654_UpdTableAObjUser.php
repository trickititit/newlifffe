<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdTableAObjUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aobject_user', function (Blueprint $table) {
            $table->integer('user_id', false, true)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->integer('aobject_id', false, true)->nullable();
            $table->foreign('aobject_id')->references('id')->on('aobjects')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aobject_user', function (Blueprint $table) {
            //
        });
    }
}
