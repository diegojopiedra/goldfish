<?php

use Illuminate\Database\Seeder;
use App\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'description' => 'Disponible',
        ]);
        State::create([
            'description' => 'Prestado',
        ]);
        State::create([
            'description' => 'Fuera de servicio',
        ]);
        State::create([
            'description' => 'En reparación',
        ]);
    }
}
