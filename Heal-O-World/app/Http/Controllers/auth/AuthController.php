<?php

namespace App\Http\Controllers\auth;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController 
{
    public function showLoginForm(Request $request)
    {
        $role = $request->route('role'); 
        return view('auth.login', compact('role'));
    }

    public function showRegisterForm(Request $request)
    {
        $role = $request->route('role'); 
        return view('auth.register', compact('role'));
    }

    public function register(UserRegisterRequest $request)
    {
        $role = $request->route('role');
        
        if (!$role) {
            return redirect()->route('auth.select-role')->withErrors('Роль не визначена');
        }
    
        $user = User::create([
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'is_activated' => false, 
        ]);
    
        Auth::login($user);
    
        if ($role === 'doctor') {
            return redirect()->route('activation.personal');
        }
    
        return $this->redirectByRole($role);
    }

    public function login(UserLoginRequest $request)
    {
        $role = $request->route('role');
        
        if (!$role) {
            return redirect()->route('auth.select-role')->withErrors('Роль не визначена');
        }
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt(array_merge($credentials, ['role' => $role]))) {
            $user = Auth::user();
    
            if ($user->role === 'doctor' && !$user->isActivated()) {
                return redirect()->route('activation.personal');
            }
    
            return $this->redirectByRole($role);
        }
    
        return back()->withErrors(['email' => 'Невірні дані для входу']);
    }

    protected function redirectByRole($role)
    {
        return match ($role) {
            'doctor' => redirect()->route('doctor.office'),
            'patient' => redirect()->route('patient.office'),
            default => abort(403),
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect('landing');
    }
}
