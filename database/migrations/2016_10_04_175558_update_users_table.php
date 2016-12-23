<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('identity_card');
            $table->string('last_name');
            $table->string('home_phone');
            $table->string('cell_phone'); 
            $table->string('direction'); 
            $table->date('next_update_time');
            $table->boolean('active');
            $table->string('exact_address');
            $table->integer('id_district')->unsigned();
            $table->integer('role_id')->unsigned(); 
            $table->foreign('id_district')->references('id')->on('districts');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
    }
}
