<?php

use Illuminate\Database\Seeder;
use App\Editorial;

class EditorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editorials = [
            "Revista del trabajo", 
            "National Geographic", 
            "Gaceta Fiscal", 
            "Gestión Joven", 
            "Gran Tour", 
            "AMARANTO SL",
            "BORRMART SA",
            "CENTRO VET DE LEGISLACION SL",
            "CICLISMO DLC SL",
            "DESTINOS ROTEGUI SL",            
            "DIGITAL MOTO MEDIA SL",
            "DUCAL EDICIONES SL",
            "EDICIONES BROLY SL",
            "EDICIONES CULTUGRAMA SL",            
            "EDICIONES EN MARCHA SL",
            "EDICIONES MEJORA SL",
            "EDICIONES PRENSA LIBRE SL",
            "EL ESTADO MENTAL SL",
            "EXECUTIVE EXCELLENCE SL",
            "JEAN 2 EDITORES SL",
        ];
        for ($i=0; $i < 20; $i++) { 
            Editorial::create([
    	        'name'=> $editorials[$i],
    	    ]);
        }
    }
}
