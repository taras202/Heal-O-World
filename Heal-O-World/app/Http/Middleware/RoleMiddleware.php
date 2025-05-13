<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        \Log::info('User authenticated: ' . (Auth::check() ? 'Yes' : 'No'));
        \Log::info('User role: ' . (Auth::check() ? Auth::user()->role : 'Guest'));

        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        abort(403, 'Доступ заборонено');
    }

}
