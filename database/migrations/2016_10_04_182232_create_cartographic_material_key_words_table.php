<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartographicMaterialKeyWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartographic_material_key_words', function (Blueprint $table) {
            $table->int('key_word_id')->unsigned();
            $table->int('cartographic_material_id')->unsigned();

            $table->primary(['key_word_id', 'cartographic_material_id']);
            $table->foreign('key_word_id')->references('id')->on('key_word');
            $table->foreign('cartographic_material_id')->references('id')->on('cartographic_materials');
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
        Schema::drop('cartographic_material_key_words');
    }
}
