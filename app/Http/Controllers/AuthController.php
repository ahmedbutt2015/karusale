<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){

        if($request->isMethod('POST')){
            $email = $request->input('email');
            $password = $request->input('password');

            $validator = Validator::make($request->all(), [
                'email' =>  'required|email',
                'password'  =>  'required|min:6',
            ]);

            if($validator->passes()){
                if(Auth::attempt(['email' => $email , 'password' => $password ])){
                    if(!Auth::user()->verified){
                        Auth::logout();
                        session()->flash('status', 'You are not verified. First verify your email!');
                        return redirect('/login');
                    }
                    return redirect('/');
                }else{
                    session()->flash('status', 'Incorrect Credentials!');
                    return redirect('/login');
                }
            }else{
                return redirect('/login')
                    ->withErrors($validator->errors());
            }
        }
        elseif($request->isMethod('GET')){
            return view('login');
        }
    }

    public function register(Request $req){
        if($req->isMethod('GET')){

            return view('register');
        }
        if($req->isMethod('POST')){

            $email = $req->input('email');
            $password = bcrypt($req->input('password'));
            $name = $req->input('name');
            $validator = Validator::make($req->all(),[
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]);
            if($validator->passes()){
                $user = new User([
                    'email' => $email,
                    'password' => $password,
                    'name' => $name
                ]);

                if($user->save()){
                    Mail::send('emails.auth', ['user' => $user], function ($m) use ($user){
                        $m->from('bahtasham@gmail.com', 'Acme');

                        $m->to($user->email, $user->username)->subject('Confirmation Email!');
                    });
                    session()->flash('status', 'Email has been Sent. Verify your email !!');
                    return redirect('/login');
                }
            }
            else{
                return redirect('/register')->withErrors($validator->errors());
            }
        }
    }

    public function verifyUser($id){
        $user = User::where('id', '=', $id);

        if($user->count()){
            $user = $user->first();

            $user->verified = 1;

            if($user->save()){
                return redirect('/');
            }
        }
    }
}
