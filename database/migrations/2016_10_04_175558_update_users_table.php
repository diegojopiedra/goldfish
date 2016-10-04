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
            //
            $table->integer('identity_card');
            $table->string('last_name');  
            $table->date('birthdate');
            $table->integer('home_phone');
            $table->integer('cell_phone'); 
            $table->date('next_update_time');
            $table->boolean('active');  
            $table->integer('role_id')->unsigned(); 
            $table->foreign('role_id')->references('id')->on('role');
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
            //
        });
    }
}
