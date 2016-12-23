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
        $types = [
            "App\\AudiovisualMaterial",
            "App\\CartographicMaterial",
            "App\\ThreeDimensionalObject",
            "App\\Book",    
        ];
        
        $titles = [
        	'Poema de Gilgamesh',
        	'Saga de Njál',
        	'Todo se desmorona',
        	'Cuentos infantiles',
        	'Divina Comedia',
        	'Decamerón',
        	'Ficciones',
        	'Jacques el fatalista',
        	'Berlin Alexanderplatz',
        	'Crimen y castigo',
        	'El idiota',
        	'Los endemoniados',
        	'Los hermanos Karamazov',
        	'Middlemarch',
        	'El hombre invisible',
        	'Medea',
        	'¡Absalom, Absalom!',
        	'El ruido y la furia',
        	'Madame Bovary',
        	'La educación sentimental',
        	'Eneida',
        	'Mahabhárata',
        	'Hojas de hierba',
        	'La señora Dalloway',
        	'Al faro',
        	'Memorias de Adriano'
        ];
        
        $places = [
            "Costa Rica",
            "Nicaragua",
            "Panamá",
            "Colombia",
            "Venezuela",
            "Ecuador",
            "El Salvador",
        ];
        
        $aumenter = 1;
        for($i=1; $i<=20;$i++) {
            BibliographicMaterial::Create([
                'year' => $i + 2000,
                'title' => $titles[$i],
        		'signature' => $this->generateSignature(),
        		'publication_place' => $places[rand(0,(count($places)-1))],
        		'editorial_id' => $i,
                'material_id' => $aumenter,
                'material_type' => $types[$i%count($types)],
            ]);
            
            if($i%count($types) == 0){
                $aumenter = $aumenter+1;
            }
        }
    }
    public function generateSignature(){
        return (rand(100,999)) . "." .(rand(10,99)) ." " . $this->generateRandomString();
    }
    
    public function generateRandomString($length = 4) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
