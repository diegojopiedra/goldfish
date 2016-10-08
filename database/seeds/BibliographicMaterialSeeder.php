<?php

use Illuminate\Database\Seeder;
use App\BibliographicMaterial;

class BibliographicMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <20; $i++) { 
        	BibliographicMaterial::create([
        		'year' => $i + 2000,
        		'signature' => "Signatura_".$i,
        		'publication_place' => 'Costa Rica_'.$i,
        		'editorial_id' => $i,
        		]);
        }
    }
}
