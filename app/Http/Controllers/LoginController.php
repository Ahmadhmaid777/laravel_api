<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function userLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user =User::Where('email',$request->email)->first();
        if (!$user){
            return response()->json(["message"=>"عذرا هذا الايميل غير صحيح"],401);
        }

        if (Hash::check($request->password,$user->password)){
            $token=($user->createToken('laravel password Grant Clint',['user']))->accessToken;
            $response=['token'=>$token,];
            return  response($response,200);

        }else{
            return response()->json(["message"=>"عذرا  كلمة المرور غير صحيحة"],401);

        }

    }
    public function adminLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user =Admin::Where('email',$request->email)->first();
        if (!$user){
            return response()->json(["message"=>"عذرا هذا الايميل غير صحيح"],401);
        }

        if (Hash::check($request->password,$user->password)){
            config(['auth.guards.api.provider' => 'admin']);
            $token=($user->createToken('laravel password Grant Admin',['admin']))->accessToken;
            $response=['token'=>$token];
            return  response($response,200);

        }else{
            return response()->json(["message"=>"عذرا  كلمة المرور غير صحيحة"],401);

        }

    }
}
