<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Lamaran;

class CheckLamaranStatus
{
    public function handle(Request $request, Closure $next)
    {
        $lastLamaran = Lamaran::where('user_id', auth()->id())
            ->latest()
            ->first();

        if ($lastLamaran && in_array($lastLamaran->status, ['pending', 'diterima'])) {
            return redirect()->route('pelamar.status')
                ->with('info', 'Anda sudah memiliki lamaran yang sedang diproses atau telah diterima.');
        }

        return $next($request);
    }
}