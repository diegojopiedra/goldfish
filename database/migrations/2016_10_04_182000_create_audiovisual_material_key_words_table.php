<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudiovisualMaterialKeyWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audiovisual_material_key_words', function (Blueprint $table) {
            $table->int('audiovisual_material_id')->unsigned();
            $table->int('key_word_id')->unsigned();

            $table->primary(['audiovisual_material_id', 'key_word_key']);
            $table->foreign('audiovisual_material_id')->refence('id')->on('audiovisual_material');
            $table->foreign('key_word_id')->refence('id')->on('key_word');
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
        Schema::drop('audiovisual_material_key_words');
    }
}
