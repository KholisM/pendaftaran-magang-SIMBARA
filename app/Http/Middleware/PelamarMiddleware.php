<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PelamarMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'pelamar') {
            return $next($request);
        }

        return redirect('/');  // Atau ke rute lain jika pelamar tidak terautentikasi
    }
}

