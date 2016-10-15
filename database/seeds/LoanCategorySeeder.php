<?php

use Illuminate\Database\Seeder;
use App\LoanCategory;

class LoanCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$num = 6;
            for($i=0;$i < 20; $i++){
        	LoanCategory::create([
        		'limit_time'          => '22:'. ($i + 10) . ":00",
        		'name'              =>  'name_' . $i,
        		'max_hours'  =>  $num,
        		]);
        }
    }
}
