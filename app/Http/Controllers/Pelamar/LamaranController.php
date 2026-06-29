<?php

namespace App\Http\Controllers\Pelamar;

use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class LamaranController extends Controller
{
    public function create()
    {
        $pengaturan = \App\Models\Pengaturan::first();

if (!$pengaturan || !$pengaturan->magang_dibuka) {
    return redirect()->back()
        ->with('error', 'Pendaftaran magang sedang ditutup');
}
        $user = auth()->user()->load('biodata');
        
        // Cek lamaran terakhir user
        $lastLamaran = Lamaran::where('user_id', auth()->id())
            ->latest()
            ->first();

        // Jika ada lamaran dan statusnya pending atau diterima, redirect ke status
        if ($lastLamaran && in_array($lastLamaran->status, ['pending', 'diterima'])) {
            return redirect()->route('pelamar.status')
                ->with('info', 'Anda sudah memiliki lamaran yang sedang diproses atau telah diterima.');
        }

        return view('pelamar.formulir', compact('user', 'lastLamaran'));
    }

    public function destroy($id)
{
    $lamaran = Lamaran::with(['posisi'])->findOrFail($id);

    // Hanya boleh hapus jika belum diterima / belum mulai
    if (!in_array($lamaran->status, ['pending','revisi','ditolak'])) {
        return back()->with('info', 'Lamaran tidak dapat dihapus.');
    }

    // Hapus file lampiran jika ada
    if ($lamaran->surat_diterima_path && Storage::exists($lamaran->surat_diterima_path)) {
        Storage::delete($lamaran->surat_diterima_path);
    }

    // Hapus data lamaran
    $lamaran->delete();

    return back()->with('success', 'Lamaran berhasil dihapus.');
}

    public function store(Request $request)
    {
        // Cek apakah user memiliki lamaran yang pending atau diterima
        $existingLamaran = Lamaran::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'diterima'])
            ->first();

        if ($existingLamaran) {
            return redirect()->route('pelamar.status')
                ->with('error', 'Anda sudah memiliki lamaran yang sedang diproses atau telah diterima.');
        }

        // --------------------
// FIX: konversi format tanggal dari m/d/Y (format datepicker) ke Y-m-d
// supaya Laravel bisa memvalidasi 'after:today' dengan benar
if ($request->filled('tanggal_mulai')) {
    try {
        $request->merge([
            'tanggal_mulai' => Carbon::createFromFormat('m/d/Y', $request->input('tanggal_mulai'))->format('Y-m-d'),
        ]);
    } catch (\Exception $e) {
        // biarkan validasi menangani jika format tidak sesuai
    }
}

if ($request->filled('tanggal_selesai')) {
    try {
        $request->merge([
            'tanggal_selesai' => Carbon::createFromFormat('m/d/Y', $request->input('tanggal_selesai'))->format('Y-m-d'),
        ]);
    } catch (\Exception $e) {
        //
    }
}
// --------------------


        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'semester' => 'required|integer|min:1',
            'tanggal_mulai' => 'required|date|after:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'surat_pengantar' => 'required|file|mimes:pdf|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            $suratPengantarPath = $request->file('surat_pengantar')
                ->store('surat_pengantar', 'public');

            $cvPath = null;
            if ($request->hasFile('cv')) {
                $cvPath = $request->file('cv')->store('cv', 'public');
            }

            // Jika ada lamaran sebelumnya yang ditolak atau revisi, hapus file lamanya
            $oldLamaran = Lamaran::where('user_id', auth()->id())
                ->whereIn('status', ['revisi'])
                ->latest()
                ->first();

            if ($oldLamaran) {
                if (Storage::exists($oldLamaran->surat_pengantar_path)) {
                    Storage::delete($oldLamaran->surat_pengantar_path);
                }
                if ($oldLamaran->cv_path && Storage::exists($oldLamaran->cv_path)) {
                    Storage::delete($oldLamaran->cv_path);
                }
            }

            $lamaran = Lamaran::create([
                'user_id' => auth()->id(),
                'nama' => $request->nama,
                'email' => $request->email,
                'asal_sekolah' => $request->asal_sekolah,
                'jurusan' => $request->jurusan,
                'semester' => $request->semester,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'surat_pengantar_path' => $suratPengantarPath,
                'cv_path' => $cvPath,
                'status' => 'pending'
            ]);

            return redirect()->route('pelamar.status')
                ->with('success', 'Lamaran berhasil diajukan! Silahkan pantau status lamaran Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengajukan lamaran. Silakan coba lagi.');
        }
    }

    public function status()
{
    $lamarans = Lamaran::with('posisi') // WAJIB INI
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('pelamar.status', compact('lamarans'));
}

    public function rekap()
    {
        $user = Auth::user();
        
        $lamarans = Lamaran::where('user_id', $user->id)
            ->when(request('status'), function ($query) {
                return $query->where('status', request('status'));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pelamar.rekap', compact('lamarans'));
    }

    public function detail($id)
    {
        $lamaran = Lamaran::where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('pelamar.detail-lamaran', compact('lamaran'));
    }
   public function downloadSurat($id, $type)
{
    $lamaran = Lamaran::findOrFail($id);

    if ($lamaran->user_id !== auth()->id()) {
        return back()->with('error', 'Unauthorized access');
    }

    $filePath = match ($type) {
        'surat_pengantar' => $lamaran->surat_pengantar_path,
        'cv' => $lamaran->cv_path,
        'surat_diterima' => $lamaran->surat_diterima_path,
        'surat_ditolak' => $lamaran->surat_ditolak_path,
        'sertifikat' => $lamaran->sertifikat_path,
        default => null,
    };

    if (!$filePath) {
        return back()->with('error', 'File tidak tersedia.');
    }

    if (!Storage::disk('public')->exists($filePath)) {
        return back()->with('error', 'File tidak ditemukan.');
    }

    return Storage::disk('public')->download($filePath);
}
}