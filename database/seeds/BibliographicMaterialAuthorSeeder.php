<?php

use Illuminate\Database\Seeder;
use App\BibliographicMaterialAuthor;
class BibliographicMaterialAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<20;$i++) {
			DB::table('bibliographic_material_authors')->insert([
			'bibliographic_material_id'=>$i+1,
			'author_id'=>$i+1,
			
			]);
		}
    }
}
