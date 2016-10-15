<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loanables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('barcode');
            $table->string('note');
            $table->integer('loan_category_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('loan_category_id')->references('id')->on('loan_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('loanables');
    }
}
