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
        for ($i=0; $i < 20 ; $i++) { 
        	PeriodicPublication::create([
        		'signature' => 'Signatura_'.$i +1,
        		'ISSN'=> 'ISSN_'.$i +1,
        		'editorial_id'=> $i +1,
        		]);
        }
    }
}
