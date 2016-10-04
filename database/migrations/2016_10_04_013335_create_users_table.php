<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('identity_card');
            $table->string('name');
            $table->string('last_name');            
            $table->string('email')->unique();
            $table->date('birthdate');
            $table->integer('home_phone');
            $table->integer('cell_phone');                                  
            $table->string('password', 60);
            $table->date('next_update_time');
            $table->boolean('active');  
            $table->integer('role_id')->unsigned(); 
            $table->foreign('role_id')->references('id')->on('role');
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
        Schema::drop('users');
    }
}
