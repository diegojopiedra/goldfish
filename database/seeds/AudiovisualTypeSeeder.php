<?php

use Illuminate\Database\Seeder;
use App\AudiovisualType;
class AudiovisualTypeSeeder extends Seeder
{

        /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ["Portatil", "Cable HMDI", "Cable VGA", "Proyector", "Regleta", "Parlante", "Extension", "TV", "Planta de sonido", "Microfono", "Tablet", "Aula", "Grabadora"];

        for($i=0;$i < 20; $i++){
        	AudiovisualType::create([
                $name = $names[rand(0,count($names)-1)];
        		'name' => $name,
        		]);
        }
    }
}
