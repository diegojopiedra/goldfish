<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ["Portatil", "Cable HMDI", "Cable VGA", "Proyector", "Regleta", "Parlante", "Extension", "TV", "Planta de sonido", "Microfono", "Tablet", "Aula", "Grabadora"];

        for($i=0;$i < 13; $i++){
            Type::create([
                'name' => $names[$i],
                ]);
        }
    }
}
