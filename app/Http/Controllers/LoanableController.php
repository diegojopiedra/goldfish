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
            if($item->specification_type == "App\AudiovisualEquipment"){
                $item->specific->brand;
                $item->specific->model;
                $item->specific->type;
            }elseif($item->specification_type == "App\CopyPeriodicPublication"){
                $item->specific->article;
                $item->specific->periodicPublication;
                $item->specific->periodicPublication->editorial;
            }elseif($item->specification_type == "App\BibliographicMaterial"){
                $item->specific->authors;
                $item->specific->editorial;
                $item->specific->material;
                if($item->specific->material_type == 'App\AudiovisualMaterial'){
                    $item->specific->material->audiovisualFormat;
                    $item->specific->material->audiovisualType;
                }
            }
        }
        return $list;
    }
    
    public static function getRelations($loanable){
        try{
             if($loanable->specification_type == "App\AudiovisualEquipment"){
                $loanable->specific->brand;
                $loanable->specific->model;
                $loanable->specific->type;
            }elseif($loanable->specification_type == "App\CopyPeriodicPublication"){
                $loanable->specific->article;
                $loanable->specific->periodicPublication;
                $loanable->specific->periodicPublication->editorial;
            }elseif($loanable->specification_type == "App\BibliographicMaterial"){
                $loanable->specific->authors;
                $loanable->specific->editorial;
                $loanable->specific->material;
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
