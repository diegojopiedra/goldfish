<?php

use Illuminate\Database\Seeder;
use App\AudiovisualModel;

class AudiovisualModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<20;$i++) {
			AudiovisualModel::create([
			'name'=>'Name_'.$i,			
			]);
		}
    }
}
