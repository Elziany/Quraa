<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialAuthController extends Controller
{
    //
    function redirect($provider)
    {
    return Socialite::driver($provider)->redirect();
    }
 ###############ُEnd Function###############3

    function callback($provider)
    {
       $socialUser= Socialite::driver($provider)->stateless()->user();
       $existUser=User::where('email',$socialUser->email)->first();
       if(!is_null($existUser)){
        $token=$existUser->createToken('user_login')->plainTextToken;
        $Response=[
            'success'=>true,
            'data'=>$existUser,
            'token'=>$token,
            'status'=>200
        ];
        return response()->json($Response);

       }

try{
        $user=User::create([
            'name'=>$socialUser->name,
            'email'=>$socialUser->email,

        ]);
        $token=$user->craeteToken('user_regist')->plainTextToken;
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
                'message'=>'server error',
                'data'=>$ex,
                'status'=>500
            ];
            return response()->json($Response);

        }

    }
}
