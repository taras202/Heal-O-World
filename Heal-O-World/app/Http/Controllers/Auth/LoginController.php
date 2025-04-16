<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('layout.select-role-login'); 
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
        'role' => 'required|in:patient,doctor',
    ]);

    $credentials = $request->only('email', 'password');
    $credentials['role'] = $request->role;

    if (Auth::attempt($credentials)) {
        if ($request->role === 'doctor') {
            return redirect()->intended(route('doctor.dashboard'));
        } else {
            return redirect()->intended(route('patient.dashboard'));
        }
    }

    return back()->withErrors([
        'email' => 'Невірний email, пароль або роль.',
    ])->withInput($request->only('email', 'role'));
}

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

