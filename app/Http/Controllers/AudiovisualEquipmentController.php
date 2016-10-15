<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AudiovisualEquipment;
use App\Loanable;

class AudiovisualEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AudiovisualEquipment::all();
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
		$loanable = new Loanable();
		$loanable->barcode = $request->barcode;
		$loanable->note = $request->note;
		$loanable->state_id = $request->state_id;
		$loanable->save();

		$id_loanable = Loanable::where('barcode', $request->barcode)->first()->id;

		$audiovisualEq = new AudiovisualEquipment();
		$audiovisualEq->brand_id = $request->brand_id;
		$audiovisualEq->model_id = $request->model_id;
		$audiovisualEq->type_id = $request->type_id;
		$audiovisualEq->loanable_id = $id_loanable;
		$audiovisualEq->save();

		return $audiovisualEq;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		return  AudiovisualEquipment::find($id);
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
		$audiovisualEq = AudiovisualEquipment::find($id);
		$audiovisualEq->brand_id = $request->brand_id;
		$audiovisualEq->model_id = $request->model_id;
		$audiovisualEq->type_id = $request->type_id;
		$audiovisualEq->save();

		$loanable = Loanable::find($audiovisualEq->loanable_id);
		$loanable->barcode = $request->barcode;
		$loanable->note = $request->note;
		$loanable->state_id = $request->state_id;
		$loanable->save();


		return $audiovisualEq;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $audiovisualEq = AudiovisualEquipment::find($id);
        $loanable_id = $audiovisualEq->loanable_id;

        $del1 = AudiovisualEquipment::destroy($id);
        $del2 = Loanable::destroy($loanable_id);
		if($del1==true && $del2==true) {
		return 1;
		}
		return 0;
    }
}
