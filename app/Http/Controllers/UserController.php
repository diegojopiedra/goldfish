<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LoanableController;
use App\Http\Controllers\PenaltyController;
use App\User;
use App\Role;
use App\Student;
use Auth;
use JWTAuth;

class UserController extends Controller
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
    public function index(Request $request)
    {
        // $user = JWTAuth::toUser($request->token);
        // if(isset($user) && $user->role_id == 1){
            $lengthPage = 10;

            $users = User::paginate($lengthPage);
            foreach ($users as $user) {
                $user->role;
                $user->photos;
            }
            return $users;
        // }
        // return [];
    }
    
    public function getAllUsers()
    {
            return User::all();
        
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

    public function logout(Request $request)
    {
        $input = $request->all();
        return (JWTAuth::invalidate($input['token']))?'1':'0';
    }

    public function login(Request $request)
    {
        if (!$token = JWTAuth::attempt(['email'=>$request->email, 'password'=>$request->password])) {
            return response()->json(['error' => 'El usuario o contraseña incorrecta']);

        }
        $user = JWTAuth::toUser($token);
        $user->role;
        $user->student;
        if(count($user->photos)){
            $user->photo = $user->photos[0];
        }
        return response()->json(['token' => $token, 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
		$user->identity_card = $request->identity_card;
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->home_phone = $request->home_phone;
		$user->cell_phone = $request->cell_phone;
		$user->password = bcrypt($request->password);
		$user->next_update_time = $request->next_update_time;
		$user->active = $request->active;
		$user->role_id = $request->role_id;
		$user->province_id = $request->province_id;
		$user->canton_id = $request->canton_id;
		$user->district_id = $request->district_id;
		$user->save();
		if(isset($user)) {
		    return $user;	
		} else {
			return null;
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        if($user->id == $id || $user->role_id == 1){

            $userFind = User::find($id);
            $userFind->role;
            $userFind->student;
            $userFind->penalties;
            $userFind->photos;
            $userFind->loans;
            foreach($userFind->penalties as $penalty){
                $penalty->loan;
                $penalty->loan->loanable;
                LoanableController::getRelations($penalty->loan->loanable);
            }

            foreach($userFind->loans as $loan){
                $loan->loanable;
                $loan->penalty;
                LoanableController::getRelations($loan->loanable);
            }
            $userFind->photos;
            return $userFind;
            
        }
        return 0;
    }
	
	public function searchByName(Request $request){
		$txt = $request->txt;
		$txts = explode(" " , $txt);
		$result = null;
		
		if(isset($txts[1])) {
			$result = User::where('name', 'like','%'.$txts[0].'%')->where('last_name', 'like','%'.$txts[1].'%')->get();
		} else {
			$result = User::where('name', 'like','%'.$txts[0].'%')->orwhere('last_name', 'like','%'.$txts[0].'%')->get();
		}
        return $result;
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
        $user = User::find($id);
		$user->identity_card = $request->identity_card;
		$user->name = $request->name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->home_phone = $request->home_phone;
		$user->cell_phone = $request->cell_phone;
		$user->password = bcrypt($request->password);
		$user->next_update_time = $request->next_update_time;
		$user->active = $request->active;
		$user->role_id = $request->role_id;
		$user->province_id = $request->province_id;
		$user->canton_id = $request->canton_id;
		$user->district_id = $request->district_id;
		$user->save();
		
		if(isset($user)) {
		    return $user;	
		} else {
			return null;
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del1 = User::destroy($id);
		if($del1==true) {
		return 1;
		}
		return 0; 
    }
	
    public function searchByIdentification(Request $request){

        $student = Student::where('license', $request->identification)->first();
         if(isset($student)){
            $user = User::find($student->user_id);
            $penalty = new PenaltyController();
            $user->student;
            $user->penality = $penalty->searchPenaltyes($user->id);
         } else {
            if(is_numeric($request->identification)){
                $user = User::where('identity_card', $request->identification)->first();
                if(isset($user)){
                    $penalty = new PenaltyController();
                    $user->student;
                    $user->penality = $penalty->searchPenaltyes($user->id);
                }
            }
         }
         if(isset($user)){
            return $user;
         }
         return 0;
    }
}
