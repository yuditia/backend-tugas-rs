<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index');
    }

    public function authenticate(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // dd($credentials);
        

        if (Auth::attempt($credentials)) {
            // dd(Auth::attempt($credentials));
            $request->session()->regenerate();
            // dd($request->session()->regenerate());
            // dd(redirect()->intended('/dashboard'));

            Alert::success('Success Title', 'Welcomeback Master !!!');

            return redirect('/dashboard');
            // return view('layouts.index');
            // return redirect()->route('dashboard');
            // return redirect()->intended('/dashboard');
        }

        Alert::error('Error Title', 'User or password incorect');

        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect('/login');
    }
}
