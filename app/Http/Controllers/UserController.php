<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationConfirmation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function store(Request $request,$email=null)
    {
        if($email){
            $request->merge(['email'=>$email]);
        }
       
        $request->validate([
            'email'=>['required','email','unique:users,email'],
            'username'=>['required','unique:users,username','string','min:4','max:20'],
            'password'=>['required','confirmed'],
            'password_confirmation'=>['required']
        ]);

        $confirmationCode=random_int(111111,999999);

        User::create([
            'email'=>$request->email,
            'name'=>$request->name,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'confirmation_code'=>$confirmationCode,
            'user_role'=>'user'
        ]);

        Mail::send(new RegistrationConfirmation($request->email,$confirmationCode));


    }

    public function signup(){
        return "Sign up";
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name'=>['required'],
            'avatar'=>['image','dimensions:max_width=256,max_height=256'],
            'user_role'=>['required',Rule::in(['admin','user'])]
        ]);

        if($id!=auth()->user()->id){
            return response(['message'=>'Unable to update other users information!'],403);
        }

        $user=User::findOrFail($id);

        $user->name=$request->name;
        $user->avatar=$request->avatar;
        $user->user_role=$request->user_role;
        $user->save();

        return response(['message'=>'Update successful!'],200);
    }

    public function confirm(Request $request,$email)
    {
        $request->merge(['email'=>$email]);

        $request->validate([
            'email'=>['required','email'],
            'confirmation_code'=>['required']
        ]);

       
        $user=User::where('email',$request->email)
                    ->where('confirmation_code',$request->confirmation_code)
                    ->first();

        if(! $user){
            return response([
                'message'=>'Unable to confirm registration'
            ],406);
        }

        if($user->email_verified_at){
            return response([
                'message'=>'Unable to confirm already confirmed registration'
            ],403);
        }

        $user->email_verified_at=now();
        $user->save();

        return response(['message'=>'Confirmation successful!'],200);
    }
}
