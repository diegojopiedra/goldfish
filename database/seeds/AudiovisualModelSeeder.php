<?php

use Illuminate\Database\Seeder;
use App\AudiovisualModel;

class AudiovisualModelSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        $models = ["Blanco", "Ax782g", "THx", "MKo078M", "ER97T765", "Azul", "Verde", "Cafe", "JkshKK1782"]; 
    
        for($i=0; $i<count($models);$i++) {
			AudiovisualModel::create([
			'name'=> $models[$i],			
			]);
		}
    }
}
