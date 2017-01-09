<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('districts', function (Blueprint $table) {
             $table->integer('id');
             $table->string('name');
             $table->primary('id');
             $table->integer('id_canton');
             $table->foreign('id_canton')->references('id')->on('cantons');
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
        Schema::drop('districts');
    }
}
