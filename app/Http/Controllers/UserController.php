<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function delete($id){

        User::find($id)->delete();
    }

    public function edit($id, Request $request){
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->verified = $request->input('verified');
        $user->save();
    }

    public function add( Request $request){
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('email'));
        $user->verified = 1;
        $u = User::orderBy('id', 'desc')->first();
        return response()->json(['add'=>true ,'id' => $u->id]);
    }
}












