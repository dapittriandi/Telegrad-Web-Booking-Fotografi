<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role !== $role) {
            return redirect()->route('errors.access');
        }

        return $next($request);
    }
}