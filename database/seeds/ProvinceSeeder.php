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
        'SAN JOSÉ',
        'ALAJUELA',
        'HEREDIA',
        'CARTAGO',
        'PUNTARENAS',
        'GUANACASTE',
        'LIMÓN',
        ];
        for ($i = 1; $i <= count($names); $i++) {
            Province::create ([
                'id' => $i,
                'name' => $names[$i-1],
            ]);
        }
        
    }
}
