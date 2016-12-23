<?php

use Illuminate\Database\Seeder;
use App\AudiovisualMaterial;

class AudiovisualMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=16; $i <= 20 ; $i++) { 
        	AudiovisualMaterial::create([
        		'audiovisual_format_id' => rand(1,4),
        		'audiovisual_material_type_id' => rand(1,3),
        		]);
        }
    }
}
