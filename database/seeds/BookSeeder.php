<?php

use Illuminate\Database\Seeder;
use App\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=6; $i<=10;$i++) {
          Book::Create([
                'bibliographic_materials_id' => $i,
             	]);
        }
    }
}
