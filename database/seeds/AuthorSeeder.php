<?php

use Illuminate\Database\Seeder;
use App\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<20;$i++) {
			Author::create([
			'name'=>'Name_'.$i,
			'last_name'=>'Last_name_'.$i,
			
			]);
		}
    }
}
