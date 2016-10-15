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
        for ($i=0; $i < 20; $i++) { 
            Editorial::create([
    	        'name'=>'Editorial_'.$i,
    	    ]);
        }
    }
}
