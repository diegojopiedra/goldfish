<?php

use Illuminate\Database\Seeder;
use App\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20; $i++) { 
        	Article::create([
	        	'title' 	               	   =>	'Titulo_'.$i,
	        	'begin_page'                   =>	rand(1,200),
	        	'end_page'	                   =>	rand(201,400),
	        	'copy_periodic_publication_id' =>	rand(1,20),
	        ]);
        }
    }
}
