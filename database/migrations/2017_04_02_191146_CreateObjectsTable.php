<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category', false, true);
            $table->string('deal',100);
            $table->string('type', 100);
            $table->string('city', 100);
            $table->string('area', 100);
            $table->string('address');
            $table->integer('rooms', false, true);
            $table->string('build_type');
            $table->integer('floor', false, true);
            $table->integer('distance', false, true);
            $table->integer('square', false, true);
            $table->integer('build_floors', false, true);
            $table->integer('home_square', false, true);
            $table->integer('earth_square', false, true);
            $table->text('desc');
            $table->integer('price_square', false, true);
            $table->integer('price', false, true);
            $table->integer('surcharge');
            $table->string('client_contacts');
            $table->string('geo');
            $table->tinyInteger('activate_state', false, true);
            $table->tinyInteger('public', false, true);
            $table->tinyInteger('spec_offer', false, true);
            $table->tinyInteger('moderation', false, true);
            $table->timestamp('activate_at')->nullable();
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
        Schema::dropIfExists('objects');
    }
}
