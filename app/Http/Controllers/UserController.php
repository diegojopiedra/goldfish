<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
        $user = JWTAuth::toUser($request->token);
        if(isset($user) && $user->role_id == 1){
            return User::all();
        }
        return [];
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
		$user->birthdate = $request->birthdate;
		$user->home_phone = $request->home_phone;
		$user->cell_phone = $request->cell_phone;
		$user->password = bcrypt($request->password);
		$user->next_update_time = $request->next_update_time;
		$user->active = $request->active;
		$user->role_id = $request->role_id;
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
		$user->birthdate = $request->birthdate;
		$user->home_phone = $request->home_phone;
		$user->cell_phone = $request->cell_phone;
		$user->password = bcrypt($request->password);
		$user->next_update_time = $request->next_update_time;
		$user->active = $request->active;
		$user->role_id = $request->role_id;
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
        //sleep(1);

        $student = Student::where('license', $request->identification)->first();
         if(isset($student)){
            $user = User::find($student->user_id);
            $user->student;
         } else {
            if(is_numeric($request->identification)){
                $user = User::where('identity_card', $request->identification)->first();
                if(isset($user)){
                    $user->student;
                }
            }
         }
         if(isset($user)){
            return $user;
         }
         return 0;
    }
}
