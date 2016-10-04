<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreeDimensionalObjectKeyWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('three_dimensional_object_key_words', function (Blueprint $table) {
            $table->int('three_dimensional_object_id')->unsigned();
            $table->int('key_word_id')->unsigned();

            $table->primary(['three_dimensional_object_id', 'key_word_id']);
            $table->foreign('three_dimensional_object_id')->reference('id')->on('three_dimensional_object');
            $table->foreign('key_word_id')->reference('id')->on('key_word');
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
        Schema::drop('three_dimensional_object_key_words');
    }
}
