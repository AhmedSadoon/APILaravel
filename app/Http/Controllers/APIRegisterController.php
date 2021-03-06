<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;



class APIRegisterController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request -> all(),[
            'email'=>'required|string|email|max:255|unique:users',
            'name'=>'required',
            'password'=>'required'

        ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(),400);
            }

            $user = User::create([

                'name'=>$request->get('name'),
                'email'=>$request->get('email'),
                'password'=>hash::make($request->get('password')),
            ]);


        $user  = User::first();
        $token=JWTAuth::fromUser($user);
        return response()->json(compact('token'));



    }
}
