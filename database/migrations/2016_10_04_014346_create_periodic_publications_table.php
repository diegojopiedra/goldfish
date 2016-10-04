<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodicPublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodic_publications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('signature');
            $table->string('ISSN');
            $table->foreign('editorial_id')->references('id')->on('editoral');
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
        Schema::drop('periodic_publications');
    }
}
