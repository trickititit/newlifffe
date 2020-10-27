<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('objects', function (Blueprint $table) {
            $table->integer('created_id', false, true)->nullable();
            $table->foreign('created_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->integer('working_id', false, true)->nullable();
            $table->foreign('working_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->integer('pre_working_id', false, true)->nullable();
            $table->foreign('pre_working_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->integer('deleted_id', false, true)->nullable();
            $table->foreign('deleted_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->integer('completed_id', false, true)->nullable();
            $table->foreign('completed_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objects', function (Blueprint $table) {
            //
        });
    }
}
