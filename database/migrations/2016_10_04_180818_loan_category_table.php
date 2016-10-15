<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoanCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('loan_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->time('limit_time');
            $table->string('name');
            $table->integer('max_hours');
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
        Schema::drop('loan_categories');
    }
}
