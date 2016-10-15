<?php

use Illuminate\Database\Seeder;
use App\ThreeDimensionalObjectKeyWord;

class ThreeDimensionalObjectKeyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
        DB::table('three_dimensional_object_key_words')->insert([
        	'three_dimensional_object_id' => $i+1,
        	'key_word_id' => $i+1,
        	]);
        }
    }
}
