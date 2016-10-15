<?php

use Illuminate\Database\Seeder;
use App\Loan;
class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i < 20; $i++){
        	Loan::create([

        		'departure_time'       =>  '2016-10-' . $i . ' 02:20:' . ($i + 10),
                'return_time'          =>  '2016-11-' . $i . ' 02:20:' . ($i + 10),
                'user_return_time'          =>  '2016-11-' . $i . ' 02:20:' . ($i + 10),
        		'user_id'              =>  $i+1,
        		'authorizing_user_id'  =>  $i+1,
        		'loanable_id'          =>  $i+1,
        		]);

        }
    }
}
