<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
Use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;



class APILoginController extends Controller
{
    public function login(Request $request){
        $validator=Validator::make($request -> all(),[
            'email'=>'required|string|email|max:255',
            'password'=>'required',


        ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $credentials = $request->only('email','password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }
}

