<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
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

        $mailers = [
            'gmail.com',
            'hotmail.com',
            'ucr.ac.cr',
            'hotmail.es',
            'ucrso.info',
            'yahoo.com',
            'outlook.com',
        ];

        User::create([
            'name' => 'Diego',
            'email' => 'diegojopiedra@gmail.com',
            'password' => bcrypt('1234'),
            'identity_card' => 207400490,
            'last_name' => 'Piedra Araya',
            'home_phone' => 0,
            'cell_phone' => rand(30000000,89999999),
            'next_update_time' => '2017-04-06',
            'active' => true,
            'role_id' => 1,
            'id_district' => 1,
        ]);
        $nums = array();
        array_push($nums, 207400490);
        for ($i=1; $i < 20; $i++) { 
            $name = $names[rand(0,count($names)-1)]; 
            $last_name_1 = $last_names[rand(0,count($last_names)-1)];
            $last_name_2 = $last_names[rand(0,count($last_names)-1)];
            User::create([
                'name' => $name,
                'email' => strtolower($name) . "." . strtolower($last_name_1) . $i ."@" . $mailers[rand(0,count($mailers)-1)],
                'password' => bcrypt('1234'),
                'identity_card' => $this->getCard($nums),
                'last_name' => $last_name_1 . " " . $last_name_2,
                'home_phone' => rand(30000000,89999999),
                'cell_phone' => rand(30000000,89999999),
                'next_update_time' => (rand(15,17) + 2000) . '-' . rand(1,12) . '-'. rand(1,28),
                'active' => true,
                'role_id' => rand(1,3),
                'id_district' => $i,
                'direction' => "Contiguo a UCR Tacares, Grecia, Alajuela, Costa Rica",
            ]);
        }
    }

    public function getCard($nums)
    {
        do{
            $num = 0; 
            $num = rand(1,7) * 100000000;
            $num += rand(100,999) * 10000;
            $num += rand(100,999);
            $sNum = strval($num);
        }while(in_array($sNum,$nums));
        array_push($nums, $sNum);
        return $num;
    }
}
