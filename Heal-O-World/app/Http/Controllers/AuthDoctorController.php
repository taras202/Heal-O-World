<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class AuthDoctorController extends Controller
{
    public function showLoginForm()
    {
        return view('auth_doctor.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('doctor')->attempt($credentials)) {
            return redirect()->intended(route('landing'))->with('success', 'Вхід виконано успішно!');
        }

        return back()->withErrors(['email' => 'Невірний email або пароль']);
    }

    public function showRegisterForm()
    {
        return view('auth_doctor.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctors,email', 
            'password' => 'required|string|min:6|confirmed', 
        ]);

        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
        ]);

        Auth::guard('doctor')->login($doctor);

        return redirect()->route('landing')->with('success', 'Ласкаво просимо на платформу!');
    }

    public function logout()
    {
        Auth::guard('doctor')->logout();
        return redirect()->route('doctor.login')->with('info', 'Ви вийшли з системи');
    }
}
