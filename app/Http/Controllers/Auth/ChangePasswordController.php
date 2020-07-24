<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('auth.passwords.change');
    }

    public function changepassword(Request $request)
    {
        $this->validate($request, [
            'oldpassword' => 'required|min:8',
            'new_password' => 'required',
            'confirmpassword' => 'same:new_password'
        ]);
        echo $password = Auth::user()->password;
        echo "<br/>";
        echo $request->oldpassword;
        // die;
        if (Hash::check($request->oldpassword, $password)) {
            $user = User::find(Auth::id());
            echo Auth::id();
            $user->password = Hash::make($request->new_password);
            $user->save();
            Auth::logout();
            return redirect()->route('login')->with('success', 'Password changed successfully..');
        } else {
            return redirect()->back()->with('errorMsg', 'Current password is invalid!');
        }
    }
}
