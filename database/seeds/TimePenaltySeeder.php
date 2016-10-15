<?php

use Illuminate\Database\Seeder;
use App\TimePenalty;

class TimePenaltySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<20;$i++) {
			TimePenalty::create([
			'penalty_time_finish'=>'2016-10-' . (10+$i),
			
			]);
		}
    }
}
