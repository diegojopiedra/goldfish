<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Configuration;
use App\Penalty;
use App\Loan;

use DateTime;
use DateInterval;

class PenaltyController extends Controller
{
    public function __construct(){
        $this->middleware('cros', ['except' => ['create', 'edit']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    
    public function penality(Loan $loan){
        
      $penalty = new Penalty(); 
        
        if(isset($loan) && ($loan->user_return_time > $loan->return_time)){
            $userReturn =  strtotime($loan->user_return_time);
            $returnAudio = strtotime($loan->return_time);
            $hours_penalty= $userReturn - $returnAudio;
            
            $hours_rounds = (int)($hours_penalty / 3600);
            
            $fecha = new DateTime(date('Y-m-d H:i:s'));
            $penalty->penalty_time_finish = $fecha->add(new DateInterval('P'.$hours_rounds.'D'));
            $penalty->user_id = $loan->user_id;
            $penalty->loan_id = $loan->id;
            $penalty->save();

            //return $loan->user_id;
            return $penalty;
        }
        return null;
    }
    
    public function penaltyById(Request $request){
        $penalty = Penalty::find($request->id);
        if(isset($penalty)){
            $penaltyById = Penalty::where("penality_id", "=", $penalty->id);
        }
        return $penaltyById;
    }
    
    
    public function searchPenaltyes($id){
        
        $penalties = Penalty::where("user_id", $id)->where("executed",0)->get();
        $fecha = date('Y-m-d');
        $moreLongPenalty  = '0000-00-00';
        foreach($penalties as $key => $penalty){
            if($penalty->penalty_time_finish < $fecha){
                $penalty->executed = 1;
                $penalty->save();
                array_splice($penalties, $key, 1);
            }
        }
        foreach($penalties as $penalty){
            if($penalty->penalty_time_finish > $moreLongPenalty){
                $moreLongPenalty = $penalty->penalty_time_finish;
            }
        }
        return $moreLongPenalty;
    }
    
    //Primero buscar todas las penalizaciones que no sean complido se guardan en una lista
    //si ya se cumplio cambiarla a ejecutada
    //sacarlas de la lista 
    //y buscar la que tiene mayor plazo.
}
