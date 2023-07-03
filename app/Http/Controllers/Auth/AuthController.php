<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    /*authuntication controller*/

    function userRegisteration(Request $req)
    {
        $validators=Validator::make($req->all(),[
                'firstName'=>'required|string|min:2',
                'lastName'=>'required|string|min:2',
                'email'=>'required|email|unique:users',
                'gender'=>'required|string',
                'password'=>'required|confirmed|min:8|max:15',
                'livingCountry'=>'required',
                'city'=>'required',
                'nationality'=>'required',
                'national_id'=>'required',
                'address'=>'required',
                'acadmic_qualification'=>'required',
                'functional_specialization'=>'required',
                'role_id'=>'required'

        ]);
        if($validators->fails())
        {
            $Response=[
                'success'=>false,
                'message'=>$validators->errors(),
                'status'=>500
            ];
            return response()->json($Response);
        }
        try{
        $user=User::create(
            [
                'name'=>$req->firstName." ".$req->lastName,
                'firstName'=>$req->firstName,
                'lastName'=>$req->lastName,
                'gender'=>$req->gender,
                'password'=>$req->password,
                'address'=>$req->address,
                'acadmic_qualification'=>$req->acadmic_qualification,
                'national_id'=>$req->national_id,
                'livingCountry'=>$req->livingCountry,
                'email'=>$req->email,
                'city'=>$req->city,
                'nationality'=>$req->nationality,
                'functional_specialization'=>$req->functional_specialization,
                'password'=>bcrypt($req->password),
                'role_id'=>$req->role_id // role id is 1 for admin 2 for any user
            ]
         );
        $token=$user->createToken('user_regist')->plainTextToken;
        $Response=[
            'success'=>true,
            'data'=>$user,
            'token'=>$token,
            'status'=>200
        ];
        return response()->json($Response);
    }
    catch(\Exception $ex){
        $Response=[
            'success'=>false,
            'message'=>$ex,
            'status'=>500
        ];
        return response()->json($Response);
    }
    }
    #######end function############

    function userLogin(Request $req)
    {
        $validators=Validator::make($req->all(),[
            'email'=>'required',
            'password'=>'required'
        ]);
        if($validators->fails())
        {
            $Response=[
                'success'=>false,
                'message'=>$validators->errors(),
                'status'=>500
            ];
            return response()->json($Response);
        }
        $credentials=$req->only(['email','password']);
        if(\Auth::attempt($credentials))
        {
            $user=auth()->user();
            $token=$user->createToken('user_login')->plainTextToken;
            $Response=[
                'success'=>true,
                'data'=>$user,
                'token'=>$token,
                'status'=>200
            ];
            return response()->json($Response);
        }
        else{
            $Response=[
                'success'=>false,
                'message'=>"user not found",
                'status'=>500
            ];
            return response()->json($Response);
        }
    }
    ##########end function ##########

}
