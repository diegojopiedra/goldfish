<?php

use Illuminate\Database\Seeder;
use App\ArticleAuthor;
class ArticleAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for($i=0; $i<20;$i++) {
          DB::table('article_authors')->insert([
            'article_id' => $i + 1,
            'author_id' => $i + 1,
            ]);
        }
    }
}
