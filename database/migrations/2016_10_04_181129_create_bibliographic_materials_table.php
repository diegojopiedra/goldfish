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
            $table->string('signature');
            $table->string('publication_place');
            $table->integer('editorial_id')->unsigned();
            $table->integer('loanable_id')->unsigned();
            $table->timestamps();

            $table->foreign('editorial_id')->references('id')->on('editorials');
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
        Schema::drop('bibliographic_materials');
    }
}
