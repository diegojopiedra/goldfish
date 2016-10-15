<?php

use Illuminate\Database\Seeder;
use App\KeyWord;

class KeyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i < 20; $i++){
        	KeyWord::create([

        		'word'       =>  'word_'.$i,
        		]);
        }
    }
}
