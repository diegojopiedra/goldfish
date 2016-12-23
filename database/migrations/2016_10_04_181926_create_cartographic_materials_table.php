<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartographicMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartographic_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cartographic_format_id')->unsigned();
            $table->string('dimension');
            $table->timestamps();
            
            $table->foreign('cartographic_format_id')->references('id')->on('cartographic_formats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cartographic_materials');
    }
}
