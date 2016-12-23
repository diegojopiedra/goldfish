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
        $notes = ["", "Esta dañado", "", "Perdió el color", "Contiene moho", 'Equipo nuevo'];
        $types = ["App\\AudiovisualEquipment", "App\\CopyPeriodicPublication", "App\\BibliographicMaterial"];
        
        Loanable::Create([
            'barcode' => "AU1510",
            'note' => 'Equipo nuevo',
            'state_id' => 1,
            'specification_id' => 1,
            'specification_type' => $types[0],
        ]);
            
        $aumenter = 1;
        $ids = [1,3,4];
        for($i=1; $i<60;$i++) {
            $note = $notes[rand(0,count($notes)-1)];
            Loanable::Create([
                'barcode' => "AU". (1800+$i),
                'note' => $note,
                'state_id' => $ids[rand(0,2)],
                'specification_id' => $aumenter,
                'specification_type' => $types[$i%count($types)],
            ]);
            
            
            if($i%count($types) == 0){
                $aumenter = $aumenter+1;
            }
        }
    }
}
