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
        for($i=0; $i<20;$i++) {
             AudiovisualFormat::Create([
                'name' => 'AudiovisualFormat_ ' . $i,
             	]);
        }
    }
}
