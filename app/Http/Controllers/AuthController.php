<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\storeUserRequest; 
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(!Auth::attempt($attrs)){
            return response([
                'message' => 'Invalid credentials',
            ],403);
        }
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('token-name', ['server:update'])->plainTextToken
        ],200);
    }

    public function register(Request $request){
        $user = User::create([
            'name' => $request['name'] ,
            'email' => $request['email'] ,
            'password' => Hash::make($request['password']),
        ]);
        return new UserResource($user);
    }

    public function logout(Request $request){

        if (Auth::check()){
            $user = Auth::user();//or Auth::user()
            // Revoke current user token
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return response([
                'message' => 'token supprimer'
            ],200);
        }
        return response(["message" =>"token introuvable"],404);
    }

    public function index(Request $request){
        if(Auth::check()){
            $users = User::where('id', '!=', auth()->id())->get();
            return $users;
        }
        return response(["message" =>"token introuvable"],404);
    }
}
