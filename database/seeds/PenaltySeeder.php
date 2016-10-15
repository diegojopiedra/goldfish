<?php

use Illuminate\Database\Seeder;
use App\Penalty;

class PenaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i < 20; $i++){
        	Penalty::create([

        		'loan_id' =>  $i+1,
        		]);
        }

    }
}
