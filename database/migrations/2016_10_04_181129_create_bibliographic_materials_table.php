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
            $table->string('title');
            $table->integer('year');
            $table->string('signature');
            $table->string('publication_place');
            $table->integer('editorial_id')->unsigned();
            $table->integer('material_id');
            $table->string('material_type');
            
            $table->timestamps();

            $table->foreign('editorial_id')->references('id')->on('editorials');
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
