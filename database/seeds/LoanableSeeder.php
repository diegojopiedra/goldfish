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
    $notes = [" ", "Esta dañado", " ", "Perdo el color", "Contiene moho", 'Equipo nuevo'];
        Loanable::Create([
        'barcode' => "AU1510",
        'note' => 'Equipo nuevo',
        'state_id' => 1,
        'loan_category_id' => 1,
        ]);
       for($i=1; $i<60;$i++) {
                $note = $notes[rand(0,count($notes)-1)];
             Loanable::Create([
                'barcode' => "AU". (1800+$i),
                'note' => $note,
                'state_id' => rand(1,4),
                'loan_category_id' => 1,
             	]);
         }
    }
}
