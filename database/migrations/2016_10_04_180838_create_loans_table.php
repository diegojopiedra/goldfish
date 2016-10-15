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
            $table->datetime('user_return_time');
            $table->integer('user_id')->unsigned();
            $table->integer('authorizing_user_id')->unsigned();
            $table->integer('loanable_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('authorizing_user_id')->references('id')->on('users');
            $table->foreign('loanable_id')->references('id')->on('loanables');
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
