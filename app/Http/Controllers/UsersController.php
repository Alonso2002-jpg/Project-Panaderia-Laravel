<?php

namespace App\Http\Controllers;

use App\Mail\MailableController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Displays the details of the authenticated user.
     *
     * @return \Illuminate\View\View The view displaying the user details.
     */

    public function userDetails()
    {
        $user = User::find(Auth::id());
        return view('users.detail')->with('user', $user);
    }

    /**
     * Updates the details of the authenticated user.
     *
     * @param \Illuminate\Http\Request $request The request containing the updated user details.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the user details page with a flash message.
     */

    public function updateUser(Request $request)
    {
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

    public function passwordForgotten(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = User::where('email', $request->email);
        if($user){
            $mailableController = new MailableController();
            $mailableController->sendForgotPass($user->email);
        }
        return redirect()->back();
    }

}
