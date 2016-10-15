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
        User::create([
            'name' => 'Diego',
            'email' => 'diegojopiedra@gmail.com',
            'password' => bcrypt('1234'),
            'identity_card' => 207400490,
            'last_name' => 'Piedra Araya',
            'birthdate' => '1995-06-06',
            'home_phone' => 0,
            'cell_phone' => rand(30000000,89999999),
            'next_update_time' => '2017-04-06',
            'active' => 'true',
            'role_id' => 1,
        ]);
        $nums = array();
        array_push($nums, 207400490);
        for ($i=1; $i < 20; $i++) { 
            User::create([
                'name' => 'Nombre_'.$i,
                'email' => 'correo_'.$i.'@correo.com',
                'password' => bcrypt('1234'),
                'identity_card' => $this->getCard($nums),
                'last_name' => 'apellido_'.$i,
                'birthdate' => 2000 + $i . '-3-' .$i,
                'home_phone' => rand(30000000,89999999),
                'cell_phone' => rand(30000000,89999999),
                'next_update_time' => '2010-4-'.$i,
                'active' => 'true',
                'role_id' => $i+1,
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
