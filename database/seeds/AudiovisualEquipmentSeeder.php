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
        for($i=0; $i<60;$i++) {
			AudiovisualEquipment::create([
			'brand_id'=>rand(1,10),
			'model_id'=>rand(1,9),
			'type_id'=>rand(1,13),
			]);
		}
    }
}
