<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudiovisualMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiovisual_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bibliographic_material_id')->unsigned();
            $table->integer('audiovisual_format_id')->unsigned();
            $table->integer('audiovisual_material_type_id')->unsigned();            
            $table->timestamps();

            $table->foreign('bibliographic_material_id')->references('id')->on('bibliographic_materials');
            $table->foreign('audiovisual_format_id')->references('id')->on('audiovisual_formats');
            $table->foreign('audiovisual_material_type_id')->references('id')->on('audiovisual_types');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('audiovisual_materials');
    }
}
