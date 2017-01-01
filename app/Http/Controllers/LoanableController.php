<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Loanable;
use App\AudiovisualEquipment;

class LoanableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$audio = new AudiovisualEquipment();
        $audio->brand_id = 1;
        $audio->model_id = 1;
        $audio->type_id = 1;
        
        $audio->save();
        
        $loanable = new Loanable();
        $loanable->barcode = "AI1100";
        $loanable->note = "";
        $loanable->loan_category_id = 0;
        $loanable->state_id = 1;
        $loanable->barcode = "AI1100";
        $loanable->barcode = "AI1100";
        $loanable->save();
        $loanable->specific()->save($audio);*/
        
        $loanable = Loanable::find(1);
        $loanable->specific;
        //$audio->loanables()->save($loanable);
        $audio = AudiovisualEquipment::find(1);
        $audio->loanable;
        
        return $loanable;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loanable = Loanable::find($id);
        if(isset($loanable)){
            $loanable->state;
            $this->getRelations($loanable);
        }
        return $loanable;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function search(Request $request){
        $list = Loanable::paginate($request->pageLength);
        foreach($list as $item){
            $item->state;
            $this->getRelations($item);
        }
        return $list;
    }
    
    public static function getRelations($loanable){
        try{
             if($loanable->specification_type == "App\AudiovisualEquipment"){
                $brand = $loanable->specific->brand;
                $mode = $loanable->specific->model;
                $type = $loanable->specific->type;
                
                $loanable->named = $type->name . " - " . $brand->name . " - " . $mode->name;
            }elseif($loanable->specification_type == "App\CopyPeriodicPublication"){
                $specific = $loanable->specific;
                $publication = $loanable->specific->periodicPublication;
                
                $loanable->specific->article;
                $loanable->specific->periodicPublication->editorial;
                
                $loanable->named = $publication->title . " no." . $specific->number . " vol." . $specific->volume;
            }elseif($loanable->specification_type == "App\BibliographicMaterial"){
                $specific = $loanable->specific;
                $loanable->specific->authors;
                $loanable->specific->editorial;
                $loanable->specific->material;
                
                $loanable->named = $specific->title . ' - ' . $specific->editorial->name;
                if($loanable->specific->material_type == 'App\AudiovisualMaterial'){
                    $loanable->specific->material->audiovisualFormat;
                    $loanable->specific->material->audiovisualType;
                }
            }
        }catch(\Exception $e){
            return null;
        }
        return  $loanable;
    }
}
