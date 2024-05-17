<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    function register(Request $request){
        // $validData = $request->validate([
        //     'name' =>'required|string',
        //     'email' =>'required|email',
        //     'password' =>'required|string',

        // ]);

        $rules = [
            'name' => 'required|string',
            'email' =>'required|email',
            'password' =>'required|string',
        ];

       $validator =  Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json(['success' =>'false', 'message' =>'there are arrors', 'errors'=>$validator->errors()]);
        }


        $validData = $validator->validate();

        $validData['password'] = Hash::make($validData['password']);
        $user = User::create($validData);

        return response()->json(['success' => true, 'user' => $user, 'message' =>'user registerd successfully']);

    }

    function login(Request $request){
            $validData = $request->validate([
            'email' =>'required|email',
            'password' =>'required|string',

        ]);

        if(Auth::attempt($validData)){

            $token = $request->user()->createToken('api-token')->plainTextToken;

            return response()->json(['success' =>true, 'message' =>'login successfully', 'token' =>$token]);
        }else{
            return response()->json(['success' => false, 'error' => 'invalid email or password']);
        }
    }
}
