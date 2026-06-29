<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Posisi;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Biodata;


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

    $query->where('status', '!=', 'magang_selesai');

    if ($request->has('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('nama', 'LIKE', "%{$searchTerm}%")
              ->orWhere('email', 'LIKE', "%{$searchTerm}%")
              ->orWhere('asal_sekolah', 'LIKE', "%{$searchTerm}%")
              ->orWhere('jurusan', 'LIKE', "%{$searchTerm}%");
        });
    }

    $query->latest();

    $perPage = $request->input('per_page', 10);

    // INI YANG PENTING
    $pelamars = $query->with('posisi')->paginate($perPage);

    return view('admin.pelamar', compact('pelamars'));
}

   public function detailPelamar($id)
{
    $pelamar = \App\Models\Lamaran::with(['user.biodata','posisi'])
        ->findOrFail($id);

    // AMBIL SEMUA POSISI + HITUNG YANG TERISI
    $posisis = \App\Models\Posisi::withCount('lamarans')->get();

    // DEBUG SEMENTARA (WAJIB)
    // dd($posisis);

    return view('admin.detail-pelamar', [
        'pelamar' => $pelamar,
        'posisis' => $posisis
    ]);
}

   public function setPosisi(Request $request, $id)
{
    $request->validate([
        'posisi_id' => 'required|exists:posisis,id',
    ]);

    $lamaran = Lamaran::findOrFail($id);
    $posisi  = Posisi::findOrFail($request->posisi_id);

    // Hitung yang sudah isi posisi ini
    $terisi = Lamaran::where('posisi_id', $posisi->id)->count();

    if ($terisi >= $posisi->kuota) {
        return back()->with('error', 'Kuota posisi sudah penuh!');
    }

    // INI BAGIAN PALING PENTING
    $lamaran->posisi_id = $posisi->id;
    $lamaran->save();

    return back()->with('success', 'Posisi berhasil ditempatkan!');
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

    if (!$lamaran->sertifikat_path) {

     $biodata = Biodata::where('user_id', $lamaran->user_id)->first();

$pdf = Pdf::loadView('sertifikat.template', [
    'lamaran' => $lamaran,
    'biodata' => $biodata
]);

        $fileName = 'sertifikat_' . $lamaran->id . '.pdf';

        Storage::disk('public')->put(
            'sertifikat/' . $fileName,
            $pdf->output()
        );

        $lamaran->sertifikat_path = 'sertifikat/' . $fileName;
    }

    break;
        }

        $lamaran->save();

        return back()->with('success', 'Status dan dokumen berhasil diperbarui.');
    }

    public function posisi()
{
    $posisis = Posisi::all();
    return view('admin.posisi', compact('posisis'));
}

public function createPosisi()
{
    return view('admin.posisi-create');
}


public function editPosisi($id)
{
    $posisi = Posisi::findOrFail($id);
    return view('admin.posisi-edit', compact('posisi'));
}

public function updatePosisi(Request $request, $id)
{
    $posisi = Posisi::findOrFail($id);
    $posisi->update($request->all());
    return redirect()->route('admin.posisi')->with('success', 'Posisi diupdate');
}

public function destroyPosisi($id)
{
    Posisi::findOrFail($id)->delete();
    return back()->with('success', 'Posisi dihapus');
}

public function storePosisi(Request $request)
{
    $request->validate([
        'nama_posisi' => 'required',
        'kuota' => 'required|integer',
        'deskripsi' => 'nullable'
    ]);

    Posisi::create($request->all());

    return back()->with('success', 'Posisi berhasil ditambahkan');
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

    if (!Storage::disk('public')->exists($lamaran->sertifikat_path)) {
        return back()->with('error', 'File sertifikat tidak ditemukan.');
    }

    return Storage::disk('public')->download(
        $lamaran->sertifikat_path,
        'sertifikat_magang_' . Str::slug($lamaran->nama) . '.pdf'
    );
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
    public function destroy($id)
{
    $alumni = Lamaran::findOrFail($id);

    if ($alumni->sertifikat_path && \Storage::exists($alumni->sertifikat_path)) {
        \Storage::delete($alumni->sertifikat_path);
    }

    $alumni->delete();

    return redirect()->route('admin.alumni')->with('success', 'Data alumni berhasil dihapus.');
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