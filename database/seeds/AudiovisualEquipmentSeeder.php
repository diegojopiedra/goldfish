<?php

use Illuminate\Database\Seeder;
use App\AudiovisualEquipment;

class AudiovisualEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<20;$i++) {
			AudiovisualEquipment::create([
			'brand_id'=>$i+1,
			'model_id'=>$i+1,
			'type_id'=>$i+1,
            'loanable_id'=>$i+1,
			]);
		}
    }
}
