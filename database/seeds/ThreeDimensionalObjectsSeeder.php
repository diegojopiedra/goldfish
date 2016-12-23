<?php

use Illuminate\Database\Seeder;
use App\ThreeDimensionalObject;

class ThreeDimensionalObjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=1; $i <=5; $i++) { 
	        ThreeDimensionalObject::create([
		        'physical_description'=> 'Mesa de '.$i . ' patas',
		    ]); 
	    }
    }
}
