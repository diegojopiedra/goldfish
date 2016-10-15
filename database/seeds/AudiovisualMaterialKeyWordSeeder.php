<?php

use Illuminate\Database\Seeder;
use App\AudiovisualMaterialKeyWord;

class AudiovisualMaterialKeyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i < 5; $i++){
        	DB::table('audiovisual_material_key_words')->insert([
            'audiovisual_material_id' => $i+1,
            'key_word_id' => $i+1,
        ]);
        }
    }
}
