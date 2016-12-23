<?php

use Illuminate\Database\Seeder;
use App\AudiovisualFormat;

class AudiovisualFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formats  = [
            "VHS",
            "DVD",
            "CD",
            "Lámina"
        ];
        for($i=0; $i<count($formats);$i++) {
             AudiovisualFormat::Create([
                'name' => $formats[$i],
             ]);
        }
    }
}
