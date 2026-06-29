<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelamarController extends Controller
{
    public function showForm()
    {
        $user = Auth::user();
        $existingLamaran = Lamaran::where('user_id', $user->id)
                                 ->latest()
                                 ->first();

        if ($existingLamaran) {
            if ($existingLamaran->status === 'ditolak') {
                // Show form for new application with previous data
                return view('pelamar.formulir', [
                    'user' => $user,
                    'previousApplication' => $existingLamaran
                ]);
            }
            
            // Redirect to status page with appropriate message
            $statusMessages = [
                'pending' => 'Lamaran Anda sedang dalam proses review.',
                'diterima' => 'Selamat! Lamaran Anda telah diterima.',
                'ditolak' => 'Maaf, lamaran Anda ditolak.'
            ];

            return redirect()->route('pelamar.status')
                           ->with('info', $statusMessages[$existingLamaran->status] ?? 'Anda telah memiliki lamaran aktif.');
        }

        return view('pelamar.formulir', ['user' => $user]);
    }

    public function storeForm(Request $request)
    {
        $user = Auth::user();
        $existingLamaran = Lamaran::where('user_id', $user->id)
                                 ->latest()
                                 ->first();

        // Check if user can submit new application
        if ($existingLamaran && !$existingLamaran->canSubmitNewApplication()) {
            return redirect()->route('pelamar.status')
                           ->with('error', 'Anda tidak dapat mengajukan lamaran baru saat ini.');
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


        $validated = $request->validate([
            'nama' => 'required|string|max:32',
            'email' => 'required|string|email|max:50',
            'asal_sekolah' => 'required|string|max:50',
            'jurusan' => 'required|string|max:50',
            'semester' => 'required|integer|min:1|max:2',
            'bagian_divisi' => 'required|string|max:32',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'surat_pengantar' => 'required|file|mimes:pdf|max:2048',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Handle file uploads
        if ($request->hasFile('surat_pengantar')) {
            $suratPath = $request->file('surat_pengantar')
                               ->store('surat_pengantar/' . $user->id);
            $validated['surat_pengantar_path'] = $suratPath;
        }

        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')
                            ->store('cv/' . $user->id);
            $validated['cv_path'] = $cvPath;
        }

        // Delete old files if reapplying
        if ($existingLamaran) {
            Storage::delete([
                $existingLamaran->surat_pengantar_path,
                $existingLamaran->cv_path
            ]);
        }

        // Create new application
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';
        
        $lamaran = Lamaran::create($validated);

        return redirect()->route('pelamar.status')
                       ->with('success', 'Lamaran berhasil diajukan.');
    }

    public function status()
    {
        $user = Auth::user();
        $lamaran = Lamaran::where('user_id', $user->id)
                         ->latest()
                         ->firstOrFail();

        return view('pelamar.status', compact('lamaran'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $lamaran = Lamaran::where('user_id', $user->id)->first();

        return view('pelamar.biodata', compact('lamaran'));
    }

    public function downloadSurat($id)
    {
        $lamaran = Lamaran::findOrFail($id);
        
        // Authorization check
        if ($lamaran->user_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk mengunduh surat ini.');
        }

        // Status and file availability check
        if ($lamaran->status !== 'diterima' || !$lamaran->surat_balasan_path) {
            return redirect()->back()
                ->with('error', 'Surat balasan tidak tersedia.');
        }

        // File existence check
        if (!Storage::exists($lamaran->surat_balasan_path)) {
            return redirect()->back()
                ->with('error', 'File surat balasan tidak ditemukan.');
        }

        return Storage::download(
            $lamaran->surat_balasan_path, 
            'Surat_Balasan_Magang_' . $lamaran->nama . '.pdf'
        );
    }
    public function updatePhoto(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $user = auth()->user();
    $biodata = $user->biodata;

    if ($request->hasFile('profile_photo')) {
        // Hapus foto lama jika bukan default
        if ($biodata->profile_photo && $biodata->profile_photo !== 'default-profile.png') {
            Storage::disk('public')->delete($biodata->profile_photo);
        }

        // Upload foto baru ke storage/app/public/profile_photos
        $path = $request->file('profile_photo')->store('profile_photos', 'public');

        // Simpan path lengkap (bukan hanya nama file)
        $biodata->profile_photo = $path;
        $biodata->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
    }

    return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload foto');
}


}