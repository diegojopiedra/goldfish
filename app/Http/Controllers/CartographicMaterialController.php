<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CartographicMaterial;
use App\BibliographicMaterial;
use App\Loanable;
use App\CartographicMaterialKeyWord;
use App\LoanCategory;
use DB;
class CartographicMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CartographicMaterial::all();
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
        $bibliographicMaterial = new BibliographicMaterial();
        $loanable = new Loanable();
        $cartographicMaterial = new CartographicMaterial();
        $cartographicMaterialKeyWord =  new CartographicMaterialKeyWord();     
       
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $request->loan_category_id;
        $loanable->save();
        
        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanable->id;        
        $bibliographicMaterial->save();
        
        $cartographicMaterial->bibliographic_materials_id = $bibliographicMaterial->id;        
        $cartographicMaterial->cartographic_format_id = $request->cartographic_format_id;
        $cartographicMaterial->dimension = $request->dimension;
        $cartographicMaterial->save();
        
        $cartographicMaterialKeyWord->cartographic_material_id = $cartographicMaterial->id;
        $cartographicMaterialKeyWord->key_word_id = $request->key_word_id;
        $cartographicMaterialKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return $cartographicMaterial;
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return CartographicMaterial::find($id);
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
        $cartographicMaterial = CartographicMaterial::find($id);
        $bibliographicMaterial = BibliographicMaterial::find($cartographicMaterial->bibliographic_materials_id);
        $loanable = Loanable::find($bibliographicMaterial->loanable_id);        
        $cartographicMaterialKeyWord =  CartographicMaterialKeyWord::where('cartographic_material_id',$cartographicMaterial->id)->first();     
       
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $request->loan_category_id;
        $loanable->save();
        
        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanable->id;        
        $bibliographicMaterial->save();
        
        $cartographicMaterial->bibliographic_materials_id = $bibliographicMaterial->id;        
        $cartographicMaterial->cartographic_format_id = $request->cartographic_format_id;
        $cartographicMaterial->dimension = $request->dimension;
        $cartographicMaterial->save();
        
        $cartographicMaterialKeyWord->cartographic_material_id = $cartographicMaterial->id;
        $cartographicMaterialKeyWord->key_word_id = $request->key_word_id;
        $cartographicMaterialKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return $cartographicMaterial;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
        $cartographicMaterial = CartographicMaterial::find($id);
        $id_bibliographicMaterial = $cartographicMaterial->bibliographic_materials_id;
        $bibliographicMaterial = BibliographicMaterial::find($id_bibliographicMaterial);
        $id_loanable = $bibliographicMaterial->loanable_id;
              
        DB::table('cartographic_material_key_words')->where('cartographic_material_id', $cartographicMaterial->id)->delete();
        
        CartographicMaterial::destroy($id);
        BibliographicMaterial::destroy($id_bibliographicMaterial);
        Loanable::destroy($id_loanable);
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return 1;
    }
    
    
    /*public function testStore(Request $request)
    {
        DB::beginTransaction();
        try{
        $bibliographicMaterial = new BibliographicMaterial();
        $loanable = new Loanable();
        $cartographicMaterial = new CartographicMaterial();
        $cartographicMaterialKeyWord =  new CartographicMaterialKeyWord();     
       
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $request->loan_category_id;
        $loanable->save();
        
        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanable->id;        
        $bibliographicMaterial->save();
        
        $cartographicMaterial->bibliographic_materials_id = $bibliographicMaterial->id;        
        $cartographicMaterial->cartographic_format_id = $request->cartographic_format_id;
        $cartographicMaterial->dimension = $request->dimension;
        $cartographicMaterial->save();
        
        $cartographicMaterialKeyWord->cartographic_material_id = $cartographicMaterial->id;
        $cartographicMaterialKeyWord->key_word_id = $request->key_word_id;
        $cartographicMaterialKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return $cartographicMaterial;
    }*/
    
    /*public function testUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try{
        $cartographicMaterial = CartographicMaterial::find($id);
        $bibliographicMaterial = BibliographicMaterial::find($cartographicMaterial->bibliographic_materials_id);
        $loanable = Loanable::find($bibliographicMaterial->loanable_id);        
        $cartographicMaterialKeyWord =  CartographicMaterialKeyWord::where('cartographic_material_id',$cartographicMaterial->id)->first();     
       
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->loan_category_id = $request->loan_category_id;
        $loanable->save();
        
        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanable->id;        
        $bibliographicMaterial->save();
        
        $cartographicMaterial->bibliographic_materials_id = $bibliographicMaterial->id;        
        $cartographicMaterial->cartographic_format_id = $request->cartographic_format_id;
        $cartographicMaterial->dimension = $request->dimension;
        $cartographicMaterial->save();
        
        $cartographicMaterialKeyWord->cartographic_material_id = $cartographicMaterial->id;
        $cartographicMaterialKeyWord->key_word_id = $request->key_word_id;
        $cartographicMaterialKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return $cartographicMaterial;
    }*/
    
    /*public function testDestroy($id)
    {
        DB::beginTransaction();
        try{
        $cartographicMaterial = CartographicMaterial::find($id);
        $id_bibliographicMaterial = $cartographicMaterial->bibliographic_materials_id;
        $bibliographicMaterial = BibliographicMaterial::find($id_bibliographicMaterial);
        $id_loanable = $bibliographicMaterial->loanable_id;
              
        DB::table('cartographic_material_key_words')->where('cartographic_material_id', $cartographicMaterial->id)->delete();
        
        CartographicMaterial::destroy($id);
        BibliographicMaterial::destroy($id_bibliographicMaterial);
        Loanable::destroy($id_loanable);
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return 1;
    }*/
    

}
