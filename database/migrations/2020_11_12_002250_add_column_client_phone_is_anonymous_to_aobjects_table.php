<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnClientPhoneIsAnonymousToAobjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('AObjects', function (Blueprint $table) {
            $table->boolean('client_phone_is_anonymous')->nullable(false)->default(0)->comment('Номер защищён');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('AObjects', function (Blueprint $table) {
            $table->dropColumn('client_phone_is_anonymous');
        });
    }
}
