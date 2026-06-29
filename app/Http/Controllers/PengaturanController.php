<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaturan;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();

        return view('admin.pengaturan', compact('pengaturan'));
    }

  public function update(Request $request)
{
    $request->validate([
        'magang_dibuka' => 'required|boolean'
    ]);

    $pengaturan = \App\Models\Pengaturan::first();

    if (!$pengaturan) {
        $pengaturan = new \App\Models\Pengaturan();
    }

    $pengaturan->magang_dibuka = $request->input('magang_dibuka');
    $pengaturan->save();

    return back()->with('success', 'Pengaturan berhasil diupdate');
}
}