<?php

use Illuminate\Database\Seeder;
use App\Loanable;

class LoanableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for($i=0; $i<20;$i++) {
             Loanable::Create([
                'barcode' => $i,
                'note' => 'Nota_' . $i,
                'state_id' => $i + 1,
                'loan_category_id' => $i + 1,
             	]);
         }
    }
}
