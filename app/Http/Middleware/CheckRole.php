<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
         // Check if user is authenticated
         if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if the authenticated user has the required role
        if (Auth::user()->role !== $role) {
            // Redirect based on the user's actual role
            return match(Auth::user()->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'user' => redirect()->route('dashboard'),
                default => redirect()->route('login')
            };
        }

        return $next($request);

    }
}
