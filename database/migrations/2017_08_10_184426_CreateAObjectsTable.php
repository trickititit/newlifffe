<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AObjects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category', false, true);
            $table->string('deal',100);
            $table->string('type', 100);
            $table->string('city');
            $table->string('area');
            $table->string('address');
            $table->string('link');
            $table->integer('rooms', false, true);
            $table->string('build_type');
            $table->integer('floor', false, true);
            $table->integer('distance', false, true);
            $table->integer('square', false, true);
            $table->integer('build_floors', false, true);
            $table->integer('home_square', false, true);
            $table->integer('earth_square', false, true);
            $table->text('desc');
            $table->integer('price', false, true);
            $table->string('client_contacts');
            $table->string('client_name');
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
        Schema::dropIfExists('AObjects');
    }
}
