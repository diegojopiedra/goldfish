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
        $themes = [
            "amor",
            "niños",
            "juventud",
            "adultos mayores",
            "recursos naturales",
            "calentamiento global",
            "derretimiento de los polos",
            "autos",
            "motos",
            "viajes",
            "Costa Rica",
            "parques de diversiones",
            "navidad",
            "verano",
            "estudios universitarios",
            "roles sociales",
            "magia para niños",
            "cocina económica",
            "habitos saludables",
            "el agua",
            "tips de cocina"
        ];
        for ($i=0; $i < 40; $i++) { 
        	Article::create([
	        	'title' 	               	   =>	"Articulo sobre " . $themes[rand(0,(count($themes) - 1))],
	        	'begin_page'                   =>	rand(1,200),
	        	'end_page'	                   =>	rand(201,400),
	        	'copy_periodic_publication_id' =>	rand(1,20),
	        ]);
        }
    }
}
