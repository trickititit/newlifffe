<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComfortObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comfort_object', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id', false, true);
            $table->foreign('object_id')->references('id')->on('objects')->onDelete('CASCADE');
            $table->integer('comfort_id', false, true);
            $table->foreign('comfort_id')->references('id')->on('comforts')->onDelete('CASCADE');;
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
        Schema::dropIfExists('comfort_object');
    }
}
