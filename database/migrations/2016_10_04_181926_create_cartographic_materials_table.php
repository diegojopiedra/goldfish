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
            $table->int('bibliographic_materials_id')->unsigned();
            $table->int('cartographic_format_id')->unsigned();
            $table->string('dimension')->unsigned();
            
            $table->foreign('bibliographic_materials_id')->reference('id')->on('bibliographic_materials');
            $table->foreign('cartographic_format_id')->reference('id')->on('cartographic_format');
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
        Schema::drop('cartographic_materials');
    }
}
