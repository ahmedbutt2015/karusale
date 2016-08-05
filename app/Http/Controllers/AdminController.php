<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;

use App\Http\Requests;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $users = User::orderBy('id','desc')->get();
        return view('admin.index')->withUsers($users);
    }

    public function login(Request $request){

        if($request->isMethod('GET')){
            return view('admin.login');
        }
        else if($request->isMethod('POST')){
            $name = $request->input('username');
            $password = $request->input('password');
            $a = Admin::where('username', '=', $name)->get();
            if(count($a) ){
                if(password_verify($password,$a[0]->password)){
                    session(['name'=>$a[0]->name]);
                    return redirect('/admin');
                }
            }
            session()->flash('status', 'Incorrect Credentials!');
            return redirect('/admin/login');
        }
    }
}
