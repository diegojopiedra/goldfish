<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Student;
use Auth;

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
    public function index()
    {
        $user = Auth::user();
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

    public function logout()
    {
        return Auth::logout();
    }

    public function login(Request $request)
    {
        //return $request->email;
        if(Auth::attempt(['email' =>  $request->email, 'password' =>  $request->password])){
            return Auth::user();
        }
        return null;
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
        $user = Auth::user();
        if($user->id == $id || $user->role_id == 1){

            $userFind = User::find($id);
            $userFind->role;
            return $userFind;
            
        }
        return null;
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
        
    }
    public function searchByIdentification(Request $request){
        sleep(1);

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
         return null;
    }
}
