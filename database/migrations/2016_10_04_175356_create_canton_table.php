<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCantonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cantons', function (Blueprint $table) {
            $table->increments('id');
             $table->string('name');
             $table->integer('id_province')->unsigned();
             $table->foreign('id_province')->references('id')->on('provinces');
             $table->integer('number');
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
        Schema::drop('cantons');
    }
}
