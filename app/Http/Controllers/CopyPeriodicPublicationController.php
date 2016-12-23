<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CopyPeriodicPublication;
use App\PeriodicPublication;
use App\Loanable;
use App\Article;
use App\ArticleAuthor;
use App\ArticleKeyWord;
use DB;

class CopyPeriodicPublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CopyPeriodicPublication::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
        $copyPeriodicPublication = new CopyPeriodicPublication();
        $loanable = new Loanable();
        $article = new Article();
        $articleKeyWord = new ArticleKeyWord();
        $articleAuthor = new ArticleAuthor();
        
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $request->loan_category_id;
        $loanable->save();        
        
        $copyPeriodicPublication->number = $request->number;
        $copyPeriodicPublication->volume = $request->volume;
        $copyPeriodicPublication->periodic_publication_id = $request->periodic_publication_id;
        $copyPeriodicPublication->loanables_id = $loanable->id;
        $copyPeriodicPublication->save();
        
        $article->title = $request->title;
        $article->begin_page = $request->begin_page;
        $article->end_page =$request->end_page;
        $article->copy_periodic_publication_id = $copyPeriodicPublication->id;
        $article-> save();
        
        $articleKeyWord->article_id = $article->id;
        $articleKeyWord->key_word_id = $request->key_word_id;
        $articleKeyWord->save();
        
        $articleAuthor->article_id = $article->id;
        $articleAuthor->author_id = $request->author_id;
        $articleAuthor->save();
        }catch(\Exception $e){
					DB::rollBack();
					return 0;
		}
	    DB::commit();
        return $copyPeriodicPublication;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return CopyPeriodicPublication::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
        $copyPeriodicPublication = CopyPeriodicPublication::find($id);
        $loanable = Loanable::find($copyPeriodicPublication->loanables_id);        
        $articleId = Article::where('copy_periodic_publication_id',$copyPeriodicPublication->id)->first()->id;
        $article = Article::find($articleId);
        $articleKeyWord = ArticleKeyWord::where('article_id',$articleId)->first();
        $articleAuthor =  ArticleAuthor::where('article_id',$articleId)->first();
        
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $request->loan_category_id;
        $loanable->save();        
        
        $copyPeriodicPublication->number = $request->number;
        $copyPeriodicPublication->volume = $request->volume;
		$copyPeriodicPublication->publication_date = $request->publication_date;
        $copyPeriodicPublication->periodic_publication_id = $request->periodic_publication_id ;
        $copyPeriodicPublication->loanables_id = $loanable->id;
        $copyPeriodicPublication->save();
        
        $article->title = $request->title;
        $article->begin_page = $request->begin_page;
        $article->end_page =$request->end_page;
        $article->copy_periodic_publication_id = $copyPeriodicPublication->id;
        $article->save();
        
        $articleKeyWord->article_id = $article->id;
        $articleKeyWord->key_word_id = $request->key_word_id;
        $articleKeyWord->save();
        
        $articleAuthor->article_id = $article->id;
        $articleAuthor->author_id = $request->author_id;
        $articleAuthor->save();
        }catch(\Exception $e){
					DB::rollBack();
					return 0;
		}
	    DB::commit();
        return $copyPeriodicPublication;
    }
    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id){
        $copyPeriodicPublication = CopyPeriodicPublication::find($id);
        if(asset($copyPeriodicPublication) == true){
           DB::beginTransaction();
           try{
            $this->testDestroyArticle($id);
            CopyPeriodicPublication::destroy($id);
			$loanableId = $copyPeriodicPublication->loanables_id;
            Loanable::destroy($loanableId);
           }catch(\Exception $e){
					DB::rollBack();
					return 0;
				}
				DB::commit();
				return 1;
        }
    }
    
    public function destroyArticle($copyPeriodicPublicationId){
       $flag = false;
        DB::beginTransaction();
        try{
        while($flag == false){            
            $articleId = Article::where('copy_periodic_publication_id',$copyPeriodicPublicationId)->first()->id;
            DB::table('article_key_words')->where('article_id', $articleId)->delete();
            DB::table('article_authors')->where('article_id', $articleId)->delete();
            $flag = Article::destroy($articleId);           
        }
        }catch(\Exception $e){
				DB::rollBack();
				return false;
				}
			DB::commit();
			return $flag;
        }
    
}
