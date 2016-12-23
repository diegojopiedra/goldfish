<?php

use Illuminate\Database\Seeder;
use App\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
        'San José',
        'Heredia',
        'Cartago',
        'Puntarenas',
        'Guanacaste',
        'Limón',
        ];
        for ($i = 0; $i < count($names); $i++) {
            Province::create ([
                'name' => $names[$i],
            ]);
        }
        
    }
}
