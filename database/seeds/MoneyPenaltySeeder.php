<?php

use Illuminate\Database\Seeder;
use App\MoneyPenalty;

class MoneyPenaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i=0; $i < 20; $i++) { 
	        MoneyPenalty::create([
		        'penalty_id'=> rand(1,20),
		        'canceled'=> rand(0,1),
		    ]);
	    }
    }
}
