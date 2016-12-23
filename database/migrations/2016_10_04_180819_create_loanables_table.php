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
            $table->string('barcode');
            $table->string('note');
            $table->integer('loan_category_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('specification_id');
            $table->string('specification_type');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states');
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
