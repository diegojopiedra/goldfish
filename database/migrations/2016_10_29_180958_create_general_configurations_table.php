<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('general_configurations', function(Blueprint $table){
            $table->increments('id');
            $table->time('saturday_hour_opening');
            $table->time('saturday_hour_closing');
            $table->time('opening_hour_week');
            $table->time('closing_hour_week');
            $table->string('library_name');
            $table->string('theme');
            $table->date('next_update_time');
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
        Schema::drop('general_configurations');
    }
}
