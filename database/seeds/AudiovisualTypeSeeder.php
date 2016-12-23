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
        $names = ["Electrónico", "Audio", "Audiovisual"];

        for($i=0;$i < count($names); $i++){
        	AudiovisualType::create([
        		'name' => $names[$i],
        	]);
        }
    }
}
