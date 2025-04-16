<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthPatientController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth_patient.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients,email', 
            'password' => 'required|string|min:6|confirmed', 
        ]);

        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('patient')->login($patient);

        return redirect()->route('landing')->with('success', 'Ласкаво просимо на платформу!');
    }

    public function showLoginForm()
    {
        return view('auth_patient.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::guard('patient')->attempt($request->only('email', 'password'))) {
            return redirect()->intended(route('patient.dashboard'))->with('success', 'Вхід виконано успішно!');
        }

        return back()->withErrors(['email' => 'Невірний email або пароль']);
    }

    public function logout()
    {
        Auth::guard('patient')->logout();
        return redirect()->route('patient.login')->with('info', 'Ви вийшли з системи');
    }
}
