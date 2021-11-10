<?php

namespace App\Http\Controllers;

use App\Mail\SignupInvite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function invite(Request $request)
    {
        $request->validate([
            'email'=>['required','email']
        ]);

        $user=User::where('email',$request->email)->first();

        if($user){
            if(! $user->email_verified_at){
                return response(['message'=>'User has already been invited'],403);
            }
            return response(['message'=>'User is already registered'],403);
        }
        
        Mail::send(new SignupInvite($request->email));
    }
}
