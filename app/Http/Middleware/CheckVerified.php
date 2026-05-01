<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->is_verified) {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Akun belum diverifikasi. Hubungi superadmin.');
        }

        return $next($request);
    }
}