<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biodata;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class BiodataController extends Controller
{
    private function validateBiodataRequest(Request $request)
    {
        return $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:10',
            'agama' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'asal_sekolah' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'semester' => 'nullable|integer|min:1|max:14',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    }

    private function handlePhotoUpload($request, $biodata)
    {
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($biodata->profile_photo) {
                Storage::disk('public')->delete($biodata->profile_photo);
            }

            // Simpan foto baru
            $path = $request->file('photo')->store('profile_photos', 'public');
            return $path;
        }
        return $biodata->profile_photo;
    }

    private function updateUserName($userId, $namaLengkap)
    {
        User::where('id', $userId)->update([
            'name' => $namaLengkap
        ]);
    }

    public function getBiodata()
    {
        $user = Auth::user();
        $biodata = $user->biodata()->first();

        if (!$biodata) {
            return response()->json([
                'success' => false,
                'message' => 'Biodata tidak ditemukan.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Biodata ditemukan.',
            'data' => $biodata
        ]);
    }

    public function editBiodata()
    {
        $user = Auth::user();
        $biodata = $user->biodata()->first();

        if (!$biodata) {
            return response()->json([
                'success' => false,
                'message' => 'Biodata tidak ditemukan.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Biodata ditemukan.',
            'data' => $biodata
        ]);
    }

    public function createBiodata(Request $request)
    {
        $user = Auth::user();

        // Cek apakah user sudah memiliki biodata
        if ($user->biodata()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Biodata sudah ada. Gunakan endpoint update untuk mengubah data.',
                'data' => null
            ], 400);
        }

        // Validasi input
        $this->validateBiodataRequest($request);

        try {
            $biodata = new Biodata([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'asal_sekolah' => $request->asal_sekolah,
                'jurusan' => $request->jurusan,
                'semester' => $request->semester,
                'ipk' => $request->ipk,
            ]);

            // Handle photo upload
            $biodata->profile_photo = $this->handlePhotoUpload($request, $biodata);

            // Simpan biodata
            $biodata->save();

            // Update nama user
            $this->updateUserName($user->id, $request->nama_lengkap);

            return response()->json([
                'success' => true,
                'message' => 'Biodata berhasil dibuat!',
                'data' => $biodata
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateBiodata(Request $request)
    {
        $user = Auth::user();
        $biodata = $user->biodata()->first();

        // Jika biodata belum ada, arahkan ke endpoint create
        if (!$biodata) {
            return response()->json([
                'success' => false,
                'message' => 'Biodata belum ada. Silakan gunakan endpoint POST /biodata untuk membuat biodata baru.',
                'data' => null
            ], 404);
        }

        // Validasi input
        $this->validateBiodataRequest($request);

        try {
            // Handle photo upload
            $biodata->profile_photo = $this->handlePhotoUpload($request, $biodata);

            // Update data biodata
            $biodata->fill([
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'asal_sekolah' => $request->asal_sekolah,
                'jurusan' => $request->jurusan,
                'semester' => $request->semester,
                'ipk' => $request->ipk,
            ]);

            // Simpan perubahan
            $biodata->save();

            // Update nama user
            $this->updateUserName($user->id, $request->nama_lengkap);

            return response()->json([
                'success' => true,
                'message' => 'Biodata berhasil diperbarui!',
                'data' => $biodata
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}