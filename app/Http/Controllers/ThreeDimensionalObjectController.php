<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ThreeDimensionalObject;
use App\ThreeDimensionalObjectKeyWord;
use App\BibliographicMaterial;
use App\Loanable;

class ThreeDimensionalObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ThreeDimensionalObject::all();
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
        $bibliographicMaterial = new BibliographicMaterial();
        $loanable = new Loanable();
        $threeDimensionalObject = new ThreeDimensionalObjectController();
        $threeDimensionalObjectKeyWord =  new ThreeDimensionalObjectKeyWord();
        
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->save();
        
        $loanableId = Loanable::where('barcode', $request->barcode)->first->id;

        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanableId;        
        $bibliographicMaterial->save();
        
        $threeDimensionalObject->bibliographic_material_id = $bibliographicMaterial->id;
        $threeDimensionalObject->physical_description = $request->physical_description;
        $threeDimensionalObject->save();
        
        $threeDimensionalObjectKeyWord->three_dimensional_object_id = $threeDimensionalObject->id;
        $threeDimensionalObjectKeyWord->key_word_id = $request->key_word_id;
        $threeDimensionalObjectKeyWord->save();
        
        return $threeDimensionalObject;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ThreeDimensionalObjectKeyWord::find($id);
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
        $threeDimensionalObject = ThreeDimensionalObject::find($id);
        $bibliographicMaterial = BibliographicMaterial::find($threeDimensionalObject->bibliographic_materials_id);
        $loanable = Loanable::find($threeDimensionalObject->loanable_id);       
        
        
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->save();
        
        $loanableId = Loanable::where('barcode', $request->barcode)->first->id;

                
        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanableId;        
        $bibliographicMaterial->save();
        
        $threeDimensionalObject->bibliographic_material_id = $bibliographicMaterial->id;
        $threeDimensionalObject->physical_description = $request->physical_description;
        $threeDimensionalObject->save();              
        
        return $threeDimensionalObject;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $threeDimensionalObject = ThreeDimensionalObject::find($id);
        $id_bibliographicMaterial = $threeDimensionalObject->bibliographic_materials_id;
        $id_loanable = $threeDimensionalObject->loanable_id;
        
        
        ThreeDimensionalObject::destroy($id);
        BibliographicMaterial::destroy($id_bibliographicMaterial);
        Loanable::destroy($id_loanable);        
        DB::table('three_dimensional_object_key_words')->where('three_dimensional_object_id', $ThreeDimensionalObject->id)->delete();
        
        return 1;
    }
}
