<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $currentDate = now();
        $admin = Auth::user();
        
        $statistics = [
            'menunggu_konfirmasi' => Lamaran::where('status', 'pending')->count(),
            'permohonan_disetujui' => Lamaran::where('status', 'diterima')->count(),
            'permohonan_ditolak' => Lamaran::where('status', 'ditolak')->count(),
            'revisi_permohonan' => Lamaran::where('status', 'revisi')->count(),
            'magang_berjalan' => Lamaran::where('status', 'magang_berjalan')->count(),
            'magang_selesai' => Lamaran::where('status', 'magang_selesai')->count(),
            'total_permohonan' => Lamaran::count(),
        ];
    
        // Mengambil permohonan terbaru yang masih pending
        $recentApplications = Lamaran::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    
        return view('admin.dashboard', compact('admin', 'statistics', 'recentApplications'));
    }

    public function pelamar(Request $request)
    {
        $query = Lamaran::query();

        // Filter out completed internships
        $query->where('status', '!=', 'magang_selesai');

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                ->orWhere('asal_sekolah', 'LIKE', "%{$searchTerm}%")
                ->orWhere('jurusan', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Sort by latest
        $query->latest();

        // Pagination with dynamic per page
        $perPage = $request->input('per_page', 10);
        $pelamars = $query->paginate($perPage);

        return view('admin.pelamar', compact('pelamars'));
    }

    public function detailPelamar($id)
    {
        $pelamar = Lamaran::findOrFail($id);
        return view('admin.detail-pelamar', compact('pelamar'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak,revisi,magang_berjalan,magang_selesai',
            'surat_diterima' => 'nullable|file|mimes:pdf|max:2048',
            'surat_ditolak' => 'nullable|file|mimes:pdf|max:2048',
            'catatan_revisi' => 'nullable|string',
            'sertifikat' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $lamaran = Lamaran::findOrFail($id);
        $lamaran->status = $request->status;

        // Handle different documents based on status
        switch($request->status) {
            case 'diterima':
                if ($request->hasFile('surat_diterima')) {
                    if ($lamaran->surat_diterima_path) {
                        Storage::delete($lamaran->surat_diterima_path);
                    }
                    $lamaran->surat_diterima_path = $request->file('surat_diterima')
                        ->store('surat_diterima');
                }
                break;

            case 'ditolak':
                if ($request->hasFile('surat_ditolak')) {
                    if ($lamaran->surat_ditolak_path) {
                        Storage::delete($lamaran->surat_ditolak_path);
                    }
                    $lamaran->surat_ditolak_path = $request->file('surat_ditolak')
                        ->store('surat_ditolak');
                }
                break;

            case 'revisi':
                $lamaran->catatan_revisi = $request->catatan_revisi;
                break;

            case 'magang_selesai':
                if ($request->hasFile('sertifikat')) {
                    if ($lamaran->sertifikat_path) {
                        Storage::delete($lamaran->sertifikat_path);
                    }
                    $lamaran->sertifikat_path = $request->file('sertifikat')
                        ->store('sertifikat');
                }
                break;
        }

        $lamaran->save();

        return back()->with('success', 'Status dan dokumen berhasil diperbarui.');
    }

   public function download($id, $type)
{
    $pelamar = Lamaran::findOrFail($id);

    $filePath = match ($type) {
        'surat_pengantar' => $pelamar->surat_pengantar_path,
        'cv' => $pelamar->cv_path,
        'sertifikat' => $pelamar->sertifikat_path,
        default => null,
    };

    if (!$filePath) {
        return back()->with('error', 'File tidak tersedia.');
    }

    // Gunakan disk 'public' (karena file ada di storage/app/public)
    if (Storage::disk('public')->exists($filePath)) {
        return Storage::disk('public')->download($filePath);
    }

    return back()->with('error', 'File tidak ditemukan di penyimpanan.');
}


    public function alumni(Request $request)
    {
        // Get the number of entries per page from the request or default to 10
        $perPage = $request->get('per_page', 10);
        
        // Base query for completed internships
        $alumni = Lamaran::where('status', 'magang_selesai')
            ->orderBy('tanggal_selesai', 'desc') // Order by completion date
            ->paginate(10);
        return view('admin.alumni', compact('alumni'));

        // Handle search functionality if search parameter is present
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                ->orWhere('email', 'like', "%{$searchTerm}%")
                ->orWhere('asal_sekolah', 'like', "%{$searchTerm}%")
                ->orWhere('jurusan', 'like', "%{$searchTerm}%");
            });
        }

        // Get statistics for the view
        $statistics = [
            'total_alumni' => $query->count(),
            'total_with_certificates' => $query->whereNotNull('sertifikat_path')->count(),
            'current_month_completions' => $query->whereMonth('updated_at', now()->month)
                                            ->whereYear('updated_at', now()->year)
                                            ->count(),
        ];

        // Execute the query with pagination
        $alumni = $query->paginate($perPage);

        // Add completion duration for each alumnus
        $alumni->getCollection()->transform(function ($alumnus) {
            $startDate = \Carbon\Carbon::parse($alumnus->tanggal_mulai);
            $endDate = \Carbon\Carbon::parse($alumnus->tanggal_selesai);
            $alumnus->duration = $startDate->diffInMonths($endDate) . ' bulan';
            
            return $alumnus;
        });

        // Return view with data
        return view('admin.alumni', compact('alumni', 'statistics'))
            ->with('request', $request) // Pass the request to the view for maintaining search state
            ->with('perPage', $perPage);
    }

    public function detailAlumni($id)
    {
        $alumnus = Lamaran::where('status', 'magang_selesai')
            ->with(['user', 'user.biodata'])
            ->findOrFail($id);

        return view('admin.detail-alumni', compact('alumnus'));
    }
    public function exportAlumni()
    {
        $filename = 'alumni_magang_' . now()->format('Y-m-d_His') . '.xlsx';
        
        $alumni = Lamaran::where('status', 'magang_selesai')
            ->with(['user', 'user.biodata'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($alumnus) {
                return [
                    'Nama' => $alumnus->nama,
                    'Email' => $alumnus->email,
                    'Asal Universitas' => $alumnus->asal_sekolah,
                    'Jurusan' => $alumnus->jurusan,
                    'Tanggal Mulai' => \Carbon\Carbon::parse($alumnus->tanggal_mulai)->format('d/m/Y'),
                    'Tanggal Selesai' => \Carbon\Carbon::parse($alumnus->tanggal_selesai)->format('d/m/Y'),
                    'Durasi Magang' => \Carbon\Carbon::parse($alumnus->tanggal_mulai)
                        ->diffInMonths($alumnus->tanggal_selesai) . ' bulan',
                    'Status Sertifikat' => $alumnus->sertifikat_path ? 'Tersedia' : 'Tidak Tersedia',
                    'Tanggal Update' => $alumnus->updated_at->format('d/m/Y H:i:s'),
                ];
            });

        return Excel::download(new AlumniExport($alumni), $filename);
    }


   public function downloadSertifikat($id)
{
    $lamaran = Lamaran::findOrFail($id);

    if (!$lamaran->sertifikat_path) {
        return back()->with('error', 'Sertifikat tidak tersedia.');
    }

    // Pastikan path tanpa double “private/”
    $relativePath = str_starts_with($lamaran->sertifikat_path, 'private/')
        ? $lamaran->sertifikat_path
        : 'private/' . $lamaran->sertifikat_path;

    $fullPath = storage_path('app/' . $relativePath);

    if (!file_exists($fullPath)) {
        return back()->with('error', "File tidak ditemukan di: {$fullPath}");
    }

    return response()->download($fullPath, 'sertifikat_magang_' . Str::slug($lamaran->nama) . '.pdf');
}


    public function getAlumniStatistics()
    {
        $now = now();
        $lastMonth = $now->copy()->subMonth();

        return [
            'total_alumni' => Lamaran::where('status', 'magang_selesai')->count(),
            'this_month' => Lamaran::where('status', 'magang_selesai')
                ->whereMonth('updated_at', $now->month)
                ->whereYear('updated_at', $now->year)
                ->count(),
            'last_month' => Lamaran::where('status', 'magang_selesai')
                ->whereMonth('updated_at', $lastMonth->month)
                ->whereYear('updated_at', $lastMonth->year)
                ->count(),
            'with_certificates' => Lamaran::where('status', 'magang_selesai')
                ->whereNotNull('sertifikat_path')
                ->count(),
        ];
    }
    public function getAlumniForLandingPage()
    {
        try {
            return Lamaran::where('lamarans.status', 'magang_selesai')
                ->join('users', 'lamarans.user_id', '=', 'users.id')
                ->join('biodatas', 'users.id', '=', 'biodatas.user_id')
                ->select(
                    'lamarans.nama',
                    'lamarans.asal_sekolah',
                    'lamarans.jurusan',
                    'biodatas.profile_photo'
                )
                ->orderBy('lamarans.updated_at', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error fetching alumni data: ' . $e->getMessage());
            return collect([]); // Return empty collection if there's an error
        }
    }
}