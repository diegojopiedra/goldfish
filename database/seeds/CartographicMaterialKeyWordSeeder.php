<?php

use Illuminate\Database\Seeder;
use App\CartographicMaterialKeyWord;

class CartographicMaterialKeyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      	for($i=0; $i<5;$i++) {
          DB::table('cartographic_material_key_words')->insert([
            'key_word_id' => $i + 1,
            'cartographic_material_id' => $i + 1,
            ]);
        }
    }
}
