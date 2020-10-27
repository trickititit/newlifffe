<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdmmenusRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adm_menu_role', function (Blueprint $table) {
            $table->integer('adm_menu_id', false, true)->nullable();
            $table->foreign('adm_menu_id')->references('id')->on('adm_menus')->onDelete('SET NULL');
            $table->integer('role_id', false, true)->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adm_menu_role', function (Blueprint $table) {
            //
        });
    }
}
