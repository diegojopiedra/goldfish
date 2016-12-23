<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PeriodicPublication;
use App\CopyPeriodicPublication;
use App\Article;
use App\Loanable;
use DB;

class PeriodicPublicationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return PeriodicPublication::all();
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
		$periodicPublication = new PeriodicPublication();      
		$periodicPublication->signature = $request->signature;
		$periodicPublication->ISSN = $request->ISSN;
		$periodicPublication->editorial_id = $request->editorial_id;
		$periodicPublication->save(); 	
		return $periodicPublication;        
		
	}
	
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return PeriodicPublication::find($id);
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
		$periodicPublication = PeriodicPublication::find($id);      
		$periodicPublication->signature = $request->signature;
		$periodicPublication->ISSN = $request->ISSN;
		$periodicPublication->editorial_id = $request->editorial_id;
		$periodicPublication->save();
		return $periodicPublication;
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
   public function destroy($id)
	{
	    $periodicPublication = PeriodicPublication::find($id);
	   if(asset($periodicPublication)==true){
				DB::beginTransaction();
				try{
                $this->destroyCopyPeriodicPublication($id);
				PeriodicPublication::destroy($id);
				}catch(\Exception $e){
					DB::rollBack();
					return 0;
				}
				DB::commit();
				return 1;    
	}
	}
	
	public function destroyCopyPeriodicPublication($periodicPublicationId){
		 $flag = false;
	     DB::beginTransaction();
		try{		
		while($flag == false){
			$copyPeriodicPublicationId = CopyPeriodicPublication::where('periodic_publication_id',$periodicPublicationId)->first()->id;
			$this->destroyArticle($copyPeriodicPublicationId);
			$copyPeriodicPublication = CopyPeriodicPublication::find($copyPeriodicPublicationId);
			$loanableId = $copyPeriodicPublication->loanables_id;            
			$flag = CopyPeriodicPublication::destroy($copyPeriodicPublicationId);			
		}
		Loanable::destroy($loanableId);
        }catch(\Exception $e){
			DB::rollBack();
			return 0;
			}
		DB::commit();
		return 1; 
		        
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
