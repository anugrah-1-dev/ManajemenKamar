<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSessionExpired
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActive = session('last_active');

            // Kalau session sudah tidak ada (misalnya karena tab ditutup), logout
            if (!$lastActive) {
                Auth::logout();
                return redirect()->route('login')->with('message', 'Sesi habis, silakan login kembali.');
            }
        }

        return $next($request);
    }
}
