<?php

namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;

use Gate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Loanable;
use App\Loan;
use App\Penalty;
use App\Role;

class LoanController extends Controller
{
    private $available;
    private $borrowed;
    private $out_of_service;
    private $in_repair;

    public function __construct(){
        $this->available = 1;
        $this->borrowed = 2;
        $this->out_of_service = 3;
        $this->in_repair = 4;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Loan::all();
    }

    private function getConcreteLoanalbe($loanable)
    {
        $concreteTypes = [
            'audiovisualEquipment',
            'copyPeriodicPublication',
            'audiovisualMaterial',
            'cartographicMaterial',
            'threeDimensionalObject',
        ];

        foreach ($concreteTypes as $type) {
            if($loanable->$type != null){
                return $loanable->$type; 
            }
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loan =new Loan();
		$barcode = $request->barcode;
        $loanable = Loanable::where('barcode', $barcode)->first();
		
        $loan->departure_time = $request->departure_time;
        $loan->user_id = $request->user_id;
        $loan->return_time = $request->return_time;
        $loan->authorizing_user = Auth::user();
        $loan->loanable_id = $loanable->id; 
		
		if($loanable->state_id == 1){
			$loanable->state_id = 2;
			$loan->save();
			return $loan;
		}    
        return null;
    }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Loan::find($id);
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

    public function returnLoan(Request $request)
    {
        $barcode = $request->barcode;
        
        $loanable = Loanable::where('barcode', $barcode)->first();

        $loan = Loan::where('loanable_id', $loanable->id)->orderBy('created_at', 'desc')->first();
        
        if($loanable->state_id == $this->borrowed && $loan->user_return_time == "0000-00-00 00:00:00"){
            $loanable->state_id = $this->available;
            $loan->user_return_time = date('Y-m-d H:i:s');
            $loanable->save();
            $loan->save();
        }
        return $loan;
    }

    public function returnLoanById(Request $request){

        $user = User::find($request->id);

        if(isset($user)){
        $loanById = Loan::where('user_id' ,'=', $user->id)->where('user_return_time' ,'=', '0000-00-00 00:00:00')->get();
    }
        return $loanById;
    } 
}
