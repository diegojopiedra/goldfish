<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BibliographicMaterial;
use App\AudiovisualMaterial;
use App\AudivisualMaterialKeyWord;
use DB;

class AudiovisualMaterialController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('cros', ['except' => ['create', 'edit']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // return AudiovisualMaterial::all();
        
        $lengthPage = 10;

        $materials = AudiovisualMaterial::paginate($lengthPage);

        foreach ($materials as $material) {
            $material->audivisualFormat;
            $material->audivisualType;
            $material->signature;
                if($material->bibliographicMaterial){
                    $material->bibliographicMaterial->editorial;
                    
                }
            }
        return $materials;
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
            $audiovisualMaterial = new AudiovisualMaterial();
            $audiovisualMaterialKeyWord =  new AudivisualMaterialKeyWord();
           
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
            
            $audiovisualMaterial->bibliographic_material_id = $bibliographicMaterial->id;
            $audiovisualMaterial->audiovisual_format_id = $request->audiovisual_format_id;
            $audiovisualMaterial->audiovisual_material_type_id = $request->audiovisual_material_type_id;
            $audiovisualMaterial->save();
            
            $audiovisualMaterialKeyWord->audiovisual_material_id  = $audiovisualMaterial->id;
            $audiovisualMaterialKeyWord->key_word_id = $request->key_word_id;
            $audiovisualMaterialKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return $audiovisualMaterial;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return AudiovisualMaterial::find($id);
        
        $material = AudiovisualMaterial::find($id);
// 		$material->bibliographic_material->loanable;
// 		$material->audiovisual_format;
// 		$material->audiovisual_type;
// 		$material->bibliographicMaterial;
// 		$material->loanable->state;
		
		return $material;
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
        $audiovisualMaterial =  AudiovisualMaterial::find($id);
        $bibliographicMaterial = BibliographicMaterial::find($audiovisualMaterial->bibliographic_material_id);
        $loanable = Loanable::find($bibliographicMaterial->loanable_id);
        $audiovisualMaterialKeyWord = AudiovisualMaterialKeyWord::where('audiovisual_material_id ',$audiovisualMaterial->id)->first();
       
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
        
        $audiovisualMaterial->bibliographic_material_id = $bibliographicMaterial->id;
        $audiovisualMaterial->audiovisual_format_id = $request->audiovisual_format_id;
        $audiovisualMaterial->audiovisual_material_type_id = $request->audiovisual_material_type_id;
        $audiovisualMaterial->save();
        
        $audiovisualMaterialKeyWord->audiovisual_material_id  = $audiovisualMaterial->id;
        $audiovisualMaterialKeyWord->key_word_id = $request->key_word_id;
        $audiovisualMaterialKeyWord->save();
        }catch(\Exception $e){
            DB::rollback();
            return 0;
        }
        DB::commit();
        return $audiovisualMaterial;
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
        $audiovisualMaterial = AudiovisualMaterial::find($id);
        $id_bibliographicMaterial = $audiovisualMaterial->bibliographic_material_id;
        $bibliographicMaterial = BibliographicMaterial::find($id_bibliographicMaterial);
        $id_loanable = $bibliographicMaterial->loanable_id;
        DB::table('audiovisual_material_key_words')->where('audiovisual_material_id', $audiovisualMaterial->id)->delete();
        AudiovisualMaterial::destroy($id);
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
