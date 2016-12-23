<?php

use Illuminate\Database\Seeder;
use App\Canton;

class CantonSeeder extends Seeder
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
        'Escazú',
        'Desamparados',
        'Puriscal',
        'Tarrazú',
        'Aserrí',
        'Mora',
        'Goicoechea',
        'Santa Ana',
        'Alajuelita',
        'Vasquez de Coronado',
        'Acosta',
        'Tibás',
        'Moravia',
        'Montes de Oca',
        'Turrubares',
        'Dota',
        'Curridabat',
        'Pérez Zeledón',
        'León Cortés',
        'Alajuela',
        'San Ramón',
        'Grecia',
        'San Mateo',
        'Atenas',
        'Naranjo',
        'Palmares',
        'Poás',
        'Orotina',
        'San Carlos',
        'Alfaro Ruiz',
        'Valverde Vega',
        'Upala',
        'Los Chiles',
        'Guatuso',
        'Cartago',
        'Paraíso',
        'La Unión',
        'Jiménez',
        'Turrialba',
        'Alvarado',
        'Oreamuno',
        'El Guarco',
        'Heredia',
        'Barva',
        'Santo Domingo',
        'Santa Bárbara',
        'San Rafael',
        'San Isidro',
        'Belén',
        'Flores',
        'San Pablo',
        'Sarapiquí',
        'Liberia',
        'Nicoya',
        'Santa Cruz',
        'Bagaces',
        'Carrillo',
        'Cañas',
        'Abangares',
        'Tilarán',
        'Nandayure',
        'La Cruz',
        'Hojancha',
        'Puntarenas',
        'Esparza',
        'Buenos Aires',
        'Montes de Oro',
        'Osa',
        'Aguirre',
        'Golfito',
        'Coto Brus',
        'Parrita',
        'Corredores',
        'Garabito',
        'Limón',
        'Pococí',
        'Siquirres ',
        'Talamanca',
        'Matina',
        'Guácimo',
        ];
        
        for ($i = 0; $i < count($names); $i++) {
            Canton::create ([
                'name'=> $names [$i],
                'id_province' => rand(1,6),
            ]);
        }
    }
}
