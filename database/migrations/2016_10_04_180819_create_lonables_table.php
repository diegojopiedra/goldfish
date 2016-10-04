<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLonablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lonables', function (Blueprint $table) {
            $table->increments('id');
            $table->int('barcode');
            $table->string('note');
            $table->int('state_id')->unsigned();
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
        Schema::drop('lonables');
    }
}
