<?php

namespace App\Http\Controllers\admin\auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthAdminController extends Controller
{
    public function showLoginForm()
    {
        return view('auth-admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            return redirect()->route('admin.patients.index');
        }

        return back()->with('error', 'Невірний email або пароль.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.form');
    }
}

