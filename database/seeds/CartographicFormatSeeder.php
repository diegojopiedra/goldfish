<?php

use Illuminate\Database\Seeder;
use App\CartographicFormat;

class CartographicFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20; $i++) { 
            CartographicFormat::create([
    	        'name'=>'Formato_'.$i,
    	    ]);
        }
    }
}
