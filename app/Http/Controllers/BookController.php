<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Book;
use App\BibliographicMaterial;
use App\Loanable;
use APP\LoanCategory;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::all();
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
        $book = new Book();
        $bibliographicMateial = new BibliographicMaterial();
        $loanable = new Loanable();
        $loan_Category = new LoanCategory();
        
        $loan_Category->limit_time = $request->limit_time;
        $loan_Category->name = $request->name;
        $loan_Category->max_hours = $request->max_hours;
        $loan_Category->save();

        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $loan_category->id;
        $loanable->save();

        $bibliographicMateial->year = $request->year;
        $bibliographicMateial->signature = $request->signature;
        $bibliographicMateial->publication_place = $request->publication_place;
        $bibliographicMateial->editorial_id = $request->editorial_id;
        $bibliographicMateial->loanable_id = $loanable->id;
        $bibliographicMateial->save(); 

        $book->bibliographic_materials_id = $bibliographicMateial->id;
        $book->save();
        return $book;
    }

    public function insertTest(Request $request) {
        $book = new Book();
        $bibliographicMateial = new BibliographicMaterial();
        $loanable = new Loanable();

        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->save();

        $bibliographicMateial->year = $request->year;
        $bibliographicMateial->signature = $request->signature;
        $bibliographicMateial->publication_place = $request->publication_place;
        $bibliographicMateial->editorial_id = $request->editorial_id;
        $bibliographicMateial->save(); 

        $id_biblio = $bibliographicMateial->id;
        $id_loan = Loanable::where('barcode', $request->barcode)->first()->id;
        
        $book->loanable_id = $id_loan;
        $book->bibliographic_materials_id = $id_biblio;
        
        $book->save();


        return $book;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Book::find($id);
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
        $book = Book::find($id);
        $bibliographicMateial = BibliographicMaterial::find($book->bibliographic_materials_id);
        $loanables = BibliographicMaterial::find($bibliographicMateial->loanable_id);
        $loan_Category = Loanable::find($loanable->loan_category_id);


        $loan_Category->limit_time = $request->limit_time;
        $loan_Category->name = $request->name;
        $loan_Category->max_hours = $request->max_hours;
        $loan_Category->save();

        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $loan_category->id;
        $loanable->save();

        $bibliographicMateial->year = $request->year;
        $bibliographicMateial->signature = $request->signature;
        $bibliographicMateial->publication_place = $request->publication_place;
        $bibliographicMateial->editorial_id = $request->editorial_id;
        $bibliographicMateial->loanable_id = $loanable->id;
        $bibliographicMateial->save(); 

        
        return $book;
    }


     public function test_Update(Request $request, $id)
    {
        $book = Book::find($id);
        $bibliographicMateial = BibliographicMaterial::find($book->bibliographic_materials_id);
        $lonable = Loanable::find($book->loanable_id);
        
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->save();

        $bibliographicMateial->year = $request->year;
        $bibliographicMateial->signature = $request->signature;
        $bibliographicMateial->publication_place = $request->publication_place;
        $bibliographicMateial->editorial_id = $request->editorial_id;
        $bibliographicMateial->save(); 

        $book->loanable_id = $loanable->id;
        $book->bibliographic_materials_id = $bibliographicMateial->id;
        $book->save();
        
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        $id_BibliographicMaterial = $book->bibliographic_materials_id;
        $bibliographicMateial = BibliographicMaterial::find($id_BibliographicMaterial);
       
        $id_loanable = $bibliographicMateial->loanable_id;
        $loanable = Loanable::find($id_loanable);

        $id_loan_Category = $loanable->loan_Category_id;
        $loan_Category = Loan_Category::find($id_loan_Category);

        Book::destroy($id);
        BibliographicMaterial::destroy($id_BibliographicMaterial);
        Loanable::destroy($id_loanable);
        Loan_Category::destroy($id_loan_Category);

        return 1;
    }


    public function test_delete($id) {
        $book = Book::find($id);
        $id_BibliographicMaterial = $book->bibliographic_materials_id;
        $id_loanable = $book->loanable_id;


        $del1 = Book::destroy($id);
        $del2 = BibliographicMaterial::destroy($id_BibliographicMaterial);
        $del3 = Loanable::destroy($id_loanable);

/*
        Book::destroy($id);
        BibliographicMaterial::destroy($id_BibliographicMaterial);
        Loanable::destroy($id_loanable);
*/
        if ($del1 == true && $del2 == true && $del3 == true) {
           return 1;
        } 
        return 0;
    }
        
}