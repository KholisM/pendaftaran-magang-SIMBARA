<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('biodata');
        return view('pelamar.biodata', compact('user'));
    }

    public function edit()
    {   
        $user = auth()->user();
        return view('pelamar.edit-biodata', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:10',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'semester' => 'nullable|integer|min:1|max:14',
            'ipk' => 'nullable|numeric|min:0|max:4',

        ]);

        try {
            $path = $user->profile_photo ?? null; // Default pakai path lama

            if ($request->hasFile('photo')) {
                // Hapus foto lama jika ada
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                // Simpan foto baru
                $path = $request->file('photo')->store('profile_photos', 'public');

                // Simpan path baru ke database
                $user->update(['profile_photo' => $path]);
            }

            // Update nama & email di tabel users
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update biodata dengan path terbaru
            $user->biodata()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_lengkap' => $request->name,
                     'email' => $user->email, // ambil dari akun user login
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,
                    'asal_sekolah' => $request->asal_sekolah,
                    'jurusan' => $request->jurusan,
                    'semester' => $request->semester,
                    'ipk' => $request->ipk,
                    'profile_photo' => $path, // Pakai path terbaru
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui!',
                'redirect' => route('pelamar.biodata')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

}