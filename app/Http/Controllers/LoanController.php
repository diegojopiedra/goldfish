<?php
namespace App\Http\Controllers;
use Hash;
use Illuminate\Http\Request;
use Gate;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoanableController;
use App\Http\Controllers\PenaltyController;
use App\User;
use App\Loanable;
use App\Loan;
use App\Penalty;
use App\Role;
use App\AudiovisualModel;
use App\Type;
use App\Brand;
use JWTAuth;
use Auth;
use DB;
use DateTime;

class LoanController extends Controller
{
    private $available;
    private $borrowed;
    private $out_of_service;
    private $in_repair;
    
    public function __construct(){
        $this->middleware('cros', ['except' => ['create', 'edit']]);
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
        $order = $request->order;
        if($order == 'desc' || $order == 'asc'){
            $loans = Loan::orderBy('id', $order)->paginate();
        }else{
            $loans = Loan::paginate();
        }
        
        foreach ($loans as $loan) {
            $loan->user;
            $loan->receiver;
            $loan->authorizer;
            $loan->penalty;
            LoanableController::getRelations($loan->loanable);
        }

        return $loans;
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
        $penalty = new PenaltyController();
		$barcode = $request->barcode;
        $loanable = Loanable::where('barcode', $barcode)->first();
		    
        $loan->departure_time = date('Y-m-d H:i:s');
        $loan->user_id = $request->user_id;
        $loan->return_time = $request->return_time;
        $loan->authorizing_user_id = JWTAuth::toUser($request->token)->id;
        $loan->loanable_id = $loanable->id; 
		
		//return json_encode($penalty->searchPenaltyes($request->user_id));
        if($penalty->searchPenaltyes($request->user_id) == "0000-00-00"){
    		if($loanable->state_id == 1){
    			DB::beginTransaction();
    			try {
        			$loanable->state_id = 2;
                    $loan->loanable;
                    $loan->loanable->state;
                    if($loan->loanable->specification_type == "App\AudiovisualEquipment"){
                        $loan->loanable->specific->brand;
                        $loan->loanable->specific->model;
                        $loan->loanable->specific->type;
                    }elseif($loan->loanable->specification_type == "App\CopyPeriodicPublication"){
                        $loan->loanable->specific->article;
                        $loan->loanable->specific->periodicPublication;
                        $loan->loanable->specific->periodicPublication->editorial;
                    }elseif($loan->loanable->specification_type == "App\BibliographicMaterial"){
                        $loan->loanable->specific->authors;
                        $loan->loanable->specific->editorial;
                        $loan->loanable->specific->material;
                        if($loan->loanable->specific->material_type == 'App\AudiovisualMaterial'){
                            $loan->loanable->specific->material->audiovisualFormat;
                            $loan->loanable->specific->material->audiovisualType;
                        }
                    }
        			$loanable->save();
        			$loan->save();
    			} catch (\Exception $e){
        			DB::rollback();
        			return $e;
    			}
    			DB::commit();
    		    return $loan;
    		}else{
    		    return array("response" => "not available", "user_id" => $request->user_id);
    		}
        }else{
            return array("response" => "not available for penalty", "user_id" => $request->user_id);
        }
    }
    public function gets()
    {
        return Auth::user();
    }
	
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = Loan::find($id);
        $loan->user;
        $loan->authorizer;
        $loan->user->photos;
        $loan->authorizer->photos;
        $loan->user->student;
        $loan->authorizer->student;
        if($loan->receiver){
            $loan->receiver->photos;
            $loan->receiver->student;
        }
        $loan->penalty;
        LoanableController::getRelations($loan->loanable);
        
        return $loan;
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
        return Loan::find($id)->delete();
    }
    
    public function getLoansByLoanableId($id){
        return Loan::where('loanable_id', $id)->get();
    }
    
    public function returnLoan(Request $request)
    {	
	    $barcode = $request->barcode;
        $loanable = Loanable::where('barcode', $barcode)->first();
        $loan = Loan::where('loanable_id', $loanable->id)->orderBy('created_at', 'desc')->first();
 		$penaltyController = new PenaltyController();

            if($loanable->state_id == $this->borrowed && $loan->user_return_time == "0000-00-00 00:00:00")
		    {
		    DB::beginTransaction();
    		try{
    		    $loanable->state_id = $this->available;
                $loan->user_return_time = date('Y-m-d H:i:s');
                $loan->receiving_user_id = JWTAuth::toUser($request->token)->id;
                $loan->loanable;
                LoanableController::getRelations($loan->loanable);
                $loanable->save();
                $loan->save();
    			//return $loan;
    		} catch(\Exception $e)
    		{
    			DB::rollBack();
    			return array("response"=>"not" );
    		}
    		DB::commit();
    		
    		$loan->penality = $penaltyController->penality($loan);
     		
    		return $loan;
    		}
	    return null;
    }
	
    public function returnLoanById(Request $request){
        $user = User::find($request->id);
        if(isset($user)){
            $loanById = Loan::where('user_id' ,'=', $user->id)->where('user_return_time' ,'=', '0000-00-00 00:00:00')->get();
            foreach ($loanById as $loan) {
                $loan->loanable;
                if(isset($loan)){
                    $loan->audiovisualEquipment;
                    $loan->copyPeriodicPublication;
                    $loan->audiovisualMaterial;
                    $loan->cartographicMaterial;
                    $loan->threeDimensionalObject;
                }

                $loan->loanable;
                $loan->loanable->state;
                LoanableController::getRelations($loan->loanable);
            }
        }
        return $loanById;
    }
    
    public function automaticLoan(Request $request){

        $barcode = $request->barcode;
        $loanable = Loanable::where('barcode', $barcode)->first();

        if(!isset($loanable) || $loanable == null){
            return array('response' => "empty", "user_id" => $request->user_id);
        }

        if($loanable->state_id == $this->available){
            if($request->user_id == null){
                return array('response' => "available loanable empty user");
            }else{
                return $this->store($request);
            }
        }
        if($loanable->state_id == $this->borrowed){
            //cargar usuario del ultimo prestamo de este activo
            //se compara el usuario del prestamo con el usuario recibido por request
            $last_loan = $this->lastLoanByActive($loanable->id);
            
            if ($last_loan->user_id == $request->user_id || $request->user_id == "") {
                return $this->returnLoan($request);
            } else {
                return array('response' => "incorrect user", "user_id" => 0);
            }
            //sino que indique el estado en q esta el prestable
        }
        return array('response' => "not available", "user_id" => $request->user_id);
    }
    
    public function dayPendingsLoans() {
        $current_date = date('Y-m-d');
        $pendingLoans = Loan::where($current_date,'return_time')
                        ->get();
                 
        $result = array("pending_loans"=>$pendingLoans); 
        return json_encode($result);
    }
    
    public function getActiveHistoryById($id) {
        return json_decode(Loan::where('loanable_id',$id)->orderBy('created_at', 'desc')->simplePaginate(20)->toJson());
    }
    
    public function lastLoanByActive($loanable_id) {
    $result = Loan::where('loanable_id',$loanable_id)
                        ->orderby('departure_time','desc')
                        ->first();
    return $result;
    }
}