<?php

use Illuminate\Database\Seeder;
use App\ArticleKeyWord;

class ArticleKeyWordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
        DB::table('article_key_words')->insert([
        	'article_id'=> $i+1,
        	'key_word_id'=> $i+1,
        	]);
        }
    }
}
