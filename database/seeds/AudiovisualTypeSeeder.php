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
        for($i=0;$i < 20; $i++){
        	AudiovisualType::create([

        		'name'    =>  'type_'.$i,
        		]);

        }
    }
}
