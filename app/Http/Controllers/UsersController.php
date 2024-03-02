<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function userDetails(){
        $user = User::find(Auth::id());
        return view('users.detail')->with('user', $user);
    }

    public function updateUser(Request $request){
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'email' => 'required|email|string|max:255|unique:users,email, ' . Auth::id(),
            'phone_number' => 'sometimes|regex:/^(6|7|8|9)\d{8}$/',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->update($request->all());
        flash('User ' . $user->name . ' updated successfully.')->warning()->important();
        return redirect()->route('users.detail');
    }
}
