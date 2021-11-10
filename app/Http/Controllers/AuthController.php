<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username'=>['required'],
            'password'=>['required']
        ]);

        $user=User::where('username',$request->username)
                    ->whereNotNull('email_verified_at',)
                    ->first();

        if(! $user || ! Hash::check($request->password,$user->password)){
            return response([
                'message'=>'Invalid credentials!'
            ],401);
        }

        $user->tokens()->delete();
        $token=$user->createToken($request->username)->plainTextToken;

        return response(['token'=>$token],200);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response(['message'=>'Logged out'],200);
    }
}
