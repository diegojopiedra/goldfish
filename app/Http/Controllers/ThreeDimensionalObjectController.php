<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ThreeDimensionalObject;
use App\ThreeDimensionalObjectKeyWord;
use App\BibliographicMaterial;
use App\Loanable;
use DB;
class ThreeDimensionalObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
     public function __construct()
    {
        $this->middleware('cros', ['except' => ['create', 'edit']]);
    }
    
    
    public function index()
    {
        //return ThreeDimensionalObject::all();
         $lengthPage = 10;

        $threeDimObjs = ThreeDimensionalObject::paginate($lengthPage);

        foreach ($threeDimObjs as $threeDimObj) {
            $threeDimObj->physicalDescription;
            $threeDimObj->signature;
                if($threeDimObj->bibliographicMaterial){
                    $threeDimObj->bibliographicMaterial->editorial;
                }
            }
        return $threeDimObjs;
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     **/
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
        $threeDimensionalObject = new ThreeDimensionalObject();
        $threeDimensionalObjectKeyWord =  new ThreeDimensionalObjectKeyWord();
       
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->save();
        
        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanable->id;        
        $bibliographicMaterial->save();
        
        $threeDimensionalObject->bibliographic_material_id = $bibliographicMaterial->id;
        $threeDimensionalObject->physical_description = $request->physical_description;
        $threeDimensionalObject->save();
        
        $threeDimensionalObjectKeyWord->three_dimensional_object_id = $threeDimensionalObject->id;
        $threeDimensionalObjectKeyWord->key_word_id = $request->key_word_id;
        $threeDimensionalObjectKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
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
        return ThreeDimensionalObject::find($id);
        
        // $threeDimOb->physical_description;
        // if($threeDimOb->bibliographicMaterial){
        //     $threeDimOb->bibliographicMaterial->editorial;
        // }
        
        // return $threeDimOb;
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
        $threeDimensionalObject =  ThreeDimensionalObject::find($id);
        $bibliographicMaterial = BibliographicMaterial::find($threeDimensionalObject->bibliographic_material_id);
        $loanable = Loanable::find($bibliographicMaterial->loanable_id);
        $threeDimensionalObjectKeyWord = ThreeDimensionalObjectKeyWord::where('three_dimensional_object_id',$threeDimensionalObject->id)->first();
       
        $loanable->barcode = $request->barcode;
        $loanable->note = $request->note;
        $loanable->state_id = $request->state_id;
        $loanable->save();
        
        $bibliographicMaterial->year = $request->year;
        $bibliographicMaterial->signature = $request->signature;
        $bibliographicMaterial->publication_place = $request->publication_place;
        $bibliographicMaterial->editorial_id = $request->editorial_id;
        $bibliographicMaterial->loanable_id = $loanable->id;        
        $bibliographicMaterial->save();
        
        $threeDimensionalObject->bibliographic_material_id = $bibliographicMaterial->id;
        $threeDimensionalObject->physical_description = $request->physical_description;
        $threeDimensionalObject->save();
        
        $threeDimensionalObjectKeyWord->three_dimensional_object_id = $threeDimensionalObject->id;
        $threeDimensionalObjectKeyWord->key_word_id = $request->key_word_id;
        $threeDimensionalObjectKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return $threeDimensionalObject;
    }

     
    /**
     * Remove the specified resource from storage. *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try{
        $threeDimensionalObject = ThreeDimensionalObject::find($id);
        $id_bibliographicMaterial = $threeDimensionalObject->bibliographic_material_id;
        $bibliographicMaterial = BibliographicMaterial::find($id_bibliographicMaterial);
        $id_loanable = $bibliographicMaterial->loanable_id;
        DB::table('three_dimensional_object_key_words')->where('three_dimensional_object_id', $threeDimensionalObject->id)->delete();
        ThreeDimensionalObject::destroy($id);
        BibliographicMaterial::destroy($id_bibliographicMaterial);
        Loanable::destroy($id_loanable);
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return 1;
    }
    
    
    
}