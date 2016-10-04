<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('departure_time');
            $table->datetime('return_time');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_ud')->references('id')->on('users');
            $table->integer('authorizing_user_id')->unsigned();
            $table->foreign('authorizing_user_id')->references('id')->on('users');
            $table->integer('lonable_id')->unsigned();
            $table->foreign('lonable_id')->references('id')->on('lonables');
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
        Schema::drop('loans');
    }
}
