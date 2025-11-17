<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index()
    {
        // Ambil semua lamaran user yang sedang login
        $lamarans = Lamaran::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('pelamar.status', compact('lamarans'));
    }
}