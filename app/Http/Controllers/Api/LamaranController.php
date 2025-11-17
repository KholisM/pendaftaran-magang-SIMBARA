<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lamaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LamaranController extends Controller
{
    public function index()
    {
        try {
            $lamarans = Lamaran::with(['user', 'user.biodata'])->latest()->get();
            return response()->json([
                'success' => true,
                'data' => $lamarans
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching lamarans: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data lamaran'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Attempting to store new lamaran', [
            'user' => Auth::user()->email,
            'request_data' => $request->except(['surat_pengantar', 'cv'])
        ]);

        try {
            DB::beginTransaction();

            // Validate request
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'asal_sekolah' => 'required|string|max:255',
                'jurusan' => 'required|string|max:255',
                'semester' => 'required|integer|min:1|max:14',
                'tanggal_mulai' => 'required|date|after:today',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
                'bagian_divisi' => 'required|string|max:255',
                'surat_pengantar' => 'required|file|mimes:pdf|max:2048',
                'cv' => 'nullable|file|mimes:pdf|max:2048',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed for lamaran submission', [
                    'errors' => $validator->errors()->toArray()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Handle file uploads
            $suratPengantarPath = null;
            $cvPath = null;

            if ($request->hasFile('surat_pengantar')) {
                $file = $request->file('surat_pengantar');
                $filename = 'surat_pengantar_' . time() . '_' . Auth::id() . '.pdf';
                $suratPengantarPath = $file->storeAs('surat_pengantar', $filename, 'public');
                
                Log::info('Surat pengantar uploaded', ['path' => $suratPengantarPath]);
            }

            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $filename = 'cv_' . time() . '_' . Auth::id() . '.pdf';
                $cvPath = $file->storeAs('cv', $filename, 'public');
                
                Log::info('CV uploaded', ['path' => $cvPath]);
            }

            // Check for existing application
            $existingLamaran = Lamaran::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->first();

            if ($existingLamaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda masih memiliki lamaran yang sedang diproses'
                ], 400);
            }

            // Create lamaran
            $lamaran = Lamaran::create([
                'user_id' => Auth::id(),
                'nama' => $request->nama,
                'email' => $request->email,
                'asal_sekolah' => $request->asal_sekolah,
                'jurusan' => $request->jurusan,
                'semester' => $request->semester,
                'tanggal_mulai' => Carbon::parse($request->tanggal_mulai),
                'tanggal_selesai' => Carbon::parse($request->tanggal_selesai),
                'bagian_divisi' => $request->bagian_divisi,
                'surat_pengantar_path' => $suratPengantarPath,
                'cv_path' => $cvPath,
                'status' => 'pending'
            ]);

            DB::commit();

            Log::info('Lamaran created successfully', [
                'lamaran_id' => $lamaran->id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dibuat',
                'data' => $lamaran
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded files if they exist
            if (isset($suratPengantarPath) && Storage::disk('public')->exists($suratPengantarPath)) {
                Storage::disk('public')->delete($suratPengantarPath);
            }
            if (isset($cvPath) && Storage::disk('public')->exists($cvPath)) {
                Storage::disk('public')->delete($cvPath);
            }

            Log::error('Error creating lamaran', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat lamaran. Silakan coba lagi.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function show()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $lamarans = Lamaran::with(['user', 'user.biodata'])
                ->where('user_id', $user->id)
                ->select([
                    'id',
                    'user_id',
                    'nama',
                    'email',
                    'tanggal_mulai',
                    'tanggal_selesai',
                    'status',
                    'catatan_revisi',
                    'surat_pengantar_path',
                    'cv_path',
                    'surat_diterima_path',
                    'surat_ditolak_path',
                    'sertifikat_path',
                    'created_at',
                    'updated_at'
                ])
                ->latest()
                ->get()
                ->map(function ($lamaran) {
                    return [
                        'id' => $lamaran->id,
                        'nama' => $lamaran->nama,
                        'email' => $lamaran->email,
                        'tanggal_mulai' => $lamaran->tanggal_mulai,
                        'tanggal_selesai' => $lamaran->tanggal_selesai,
                        'status' => $lamaran->status,
                        'catatan_revisi' => $lamaran->catatan_revisi,
                        'files' => [
                            'surat_pengantar' => $lamaran->surat_pengantar_path ? url('storage/' . $lamaran->surat_pengantar_path) : null,
                            'cv' => $lamaran->cv_path ? url('storage/' . $lamaran->cv_path) : null,
                            'surat_diterima' => $lamaran->surat_diterima_path ? url('storage/' . $lamaran->surat_diterima_path) : null,
                            'surat_ditolak' => $lamaran->surat_ditolak_path ? url('storage/' . $lamaran->surat_ditolak_path) : null,
                            'sertifikat' => $lamaran->sertifikat_path ? url('storage/' . $lamaran->sertifikat_path) : null
                        ],
                        'created_at' => $lamaran->created_at,
                        'updated_at' => $lamaran->updated_at
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $lamarans
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error fetching user lamarans', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data lamaran'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lamaran = Lamaran::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'status' => 'required|in:pending,diterima,ditolak,revisi,magang_berjalan,magang_selesai',
                'catatan_revisi' => 'nullable|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $updateData = ['status' => $request->status];
            
            if ($request->has('catatan_revisi')) {
                $updateData['catatan_revisi'] = $request->catatan_revisi;
            }

            $lamaran->update($updateData);

            DB::commit();

            Log::info('Lamaran status updated', [
                'lamaran_id' => $id,
                'new_status' => $request->status,
                'updated_by' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status lamaran berhasil diperbarui',
                'data' => $lamaran
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating lamaran status', [
                'error' => $e->getMessage(),
                'lamaran_id' => $id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui status lamaran'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $lamaran = Lamaran::findOrFail($id);

            // Delete associated files
            if ($lamaran->surat_pengantar_path) {
                Storage::disk('public')->delete($lamaran->surat_pengantar_path);
            }
            if ($lamaran->cv_path) {
                Storage::disk('public')->delete($lamaran->cv_path);
            }
            if ($lamaran->surat_diterima_path) {
                Storage::disk('public')->delete($lamaran->surat_diterima_path);
            }
            if ($lamaran->surat_ditolak_path) {
                Storage::disk('public')->delete($lamaran->surat_ditolak_path);
            }
            if ($lamaran->sertifikat_path) {
                Storage::disk('public')->delete($lamaran->sertifikat_path);
            }

            $lamaran->delete();

            Log::info('Lamaran deleted', [
                'lamaran_id' => $id,
                'deleted_by' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lamaran berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting lamaran', [
                'error' => $e->getMessage(),
                'lamaran_id' => $id,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus lamaran'
            ], 500);
        }
    }
}
