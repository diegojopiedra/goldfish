<?php

use Illuminate\Database\Seeder;
use App\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Victor',
            'Vanessa',
            'Franklin',
            'Marisela',
            'Diego',
            'Katherine',
            'Jesús',
            'Sussana',
            'Farlen',
            'Sharon',
            'Alexander',
            'María José',
            'Gustavo',
            'Karol',
        ];

        $last_names = [
            'Piedra',
            'Marín',
            'Duarte',
            'Davila',
            'Rodríguez',
            'Pacheco',
            'Calderón',
            'Segura',
            'Sibaja',
            'Vargas',
            'Arce',
            'Alpízar',
        ];
        for($i=0; $i<20;$i++) {
			Author::create([
                'name'=> $names[rand(0,(count($names)) - 1)],
                'last_name'=> $last_names[rand(0,(count($last_names)) - 1)],
			]);
		}
    }
}
