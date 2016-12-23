<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Loan;
use App\Loanable;
use App\AudiovisualEquipment;
use App\Penalty;
use DB;
use DateTime;
use DateInterval;


class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

	public function getLoansByDate(Request $request) {
		$type = $request->type;
		$complete_date = $request->date1_stats;
		
		$initial_date= $request->date1_stats;
		$final_date= $request->date2_stats;
	
// 		$date = explode("-" , $complete_date);
// 		$day= $date[0];
// 		$month = $date[1];
// 		$year = $date[2];
		
		$date1 = explode("-" , $initial_date);
		$day1= $date1[0];
		$month1 = $date1[1];
		$year1 = $date1[2];
		
		$date2 = explode("-" , $final_date);
		$day2= $date2[0];
		$month2 = $date2[1];
		$year2 = $date2[2];
		
// 		$loans_by_year = DB::table('loans')
// 	              ->join('loanables','loans.loanable_id','=','loanables.id')
// 				  ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
// 				  ->where('audiovisual_equipments.type_id','=',$type)
// 				  ->whereYear('departure_time','=', $year)
// 		          ->get();
				  
// 		$loans_by_month = DB::table('loans')
// 	              ->join('loanables','loans.loanable_id','=','loanables.id')
// 				  ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
// 				  ->where('audiovisual_equipments.type_id','=',$type)
// 				  ->whereYear('departure_time','=', $year)
// 				  ->whereMonth('departure_time','=', $month)
// 		          ->get();
 	  
// 		$loans_by_day = DB::table('loans')
// 	              ->join('loanables','loans.loanable_id','=','loanables.id')
// 				  ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
// 				  ->where('audiovisual_equipments.type_id','=',$type)
// 				  ->whereYear('departure_time','=', $year)
// 				  ->whereMonth('departure_time','=', $month)
// 				  ->whereDay('departure_time','=', $day)
// 		          ->get();
				  
				
				$ini = new DateTime($year1 . "-" .$month1 . "-" . $day1);
                $fin = new DateTime($year2 . "-" .$month2 . "-" . $day2);
                
                $rank = DB::table('loans')
                  ->join('loanables','loans.loanable_id','=','loanables.id')
				  ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
				  ->whereBetween('loans.departure_time', [$ini, $fin])
				  ->where('audiovisual_equipments.type_id','=',$type)->get();
                  
		

				$result=array("cant_prestv"=>count($rank) );//,"amountYear"=>count($loans_by_year),"amountMonth"=>count($loans_by_month),"amountDay"=>count($loans_by_day));

		
    return json_encode($result);
 }
 
 public function getPendingsByDate(Request $request) {
		$type = $request->type;
		$complete_date = $request->date1_stats;
		
		$initial_date= $request->date1_stats;
		$final_date= $request->date2_stats;
	
// 		$date = explode("-" , $complete_date);
// 		$day= $date[0];
// 		$month = $date[1];
// 		$year = $date[2];
		
		$date1 = explode("-" , $initial_date);
		$day1= $date1[0];
		$month1 = $date1[1];
		$year1 = $date1[2];
		
		$date2 = explode("-" , $final_date);
		$day2= $date2[0];
		$month2 = $date2[1];
		$year2 = $date2[2];
		
// 		$pendings_by_year = DB::table('loans')
// 	              ->join('loanables','loans.loanable_id','=','loanables.id')
// 				  ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
// 				  ->where('audiovisual_equipments.type_id','=',$type)
// 				  ->where('loans.user_return_time','>','loans.return_time')
// 				  ->whereYear('departure_time','=', $year)
// 		          ->get();
				  
// 		$pendings_by_month = DB::table('loans')
// 	              ->join('loanables','loans.loanable_id','=','loanables.id')
// 				  ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
// 				  ->where('audiovisual_equipments.type_id','=',$type)
// 				  ->where('loans.user_return_time','>','loans.return_time')
// 				  ->whereYear('departure_time','=', $year)
// 				  ->whereMonth('departure_time','=', $month)
// 		          ->get();
 	  
// 		$pendings_by_day = DB::table('loans')
// 	              ->join('loanables','loans.loanable_id','=','loanables.id')
// 				  ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
// 				  ->where('audiovisual_equipments.type_id','=',$type)
// 				  ->where('loans.user_return_time','>','loans.return_time')
// 				  ->whereYear('departure_time','=', $year)
// 				  ->whereMonth('departure_time','=', $month)
// 				  ->whereDay('departure_time','=', $day)
// 		          ->get();
		          
                $ini = new DateTime($year1 . "-" .$month1 . "-" . $day1);
                $fin = new DateTime($year2 . "-" .$month2 . "-" . $day2);
            
                        
		    
		  $rank = DB::table('penalties')
		              ->join('loans','loans.id','=','penalties.loan_id')
		              ->join('loanables','loans.loanable_id','=','loanables.id')
		              ->join('audiovisual_equipments','loanables.id','=','audiovisual_equipments.loanable_id')
		              ->whereBetween('loans.departure_time', [$ini, $fin])
		              ->where('audiovisual_equipments.type_id','=',$type)
		              ->get();
		  
		  
				$result=array("cant_pendv"=>count($rank)); //"amountYear"=>count($pendings_by_year),"amountMonth"=>count($pendings_by_month),"amountDay"=>count($pendings_by_day));
            
				  
    return json_encode($result);
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
}
