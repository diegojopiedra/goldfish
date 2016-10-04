<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBibliographicMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bibliographic_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year');
            $table->foreign('editorial_Id')->references('id')->on('editorial');
            $table->string('signature');
            $table->string('publication_place');
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
        Schema::drop('bibliographic_materials');
    }
}
