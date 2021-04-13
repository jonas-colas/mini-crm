<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
   
    public function __construct()
    {
       $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8', 
        ]);

        if(Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->back()->withInput($request->only('email'));
    }

    public function logout() 
    {
        Auth::guard('user')->logout();
        return redirect('/');
    }
}
