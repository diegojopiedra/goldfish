<?php

use Illuminate\Database\Seeder;
use App\PeriodicPublication;

class PeriodicPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
        	'Divina Comedia',
        	'Decamerón',
        	'Ficciones',
        	'Jacques el fatalista',
        	'Berlin Alexanderplatz',
        	'Crimen y castigo',
        	'El idiota',
        	'Los endemoniados',
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
        for ($i=0; $i < 20 ; $i++) { 
        	PeriodicPublication::create([
        	    'title' => $titles[$i],
        		'signature' => $this->generateSignature(),
        		'ISSN'=> (rand(3000,8000)),
        		'editorial_id'=> $i +1,
        		]);
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
