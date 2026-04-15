<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        // logic login nanti
    }

    public function logout()
    {
        // logic logout
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // logic register
    }
}