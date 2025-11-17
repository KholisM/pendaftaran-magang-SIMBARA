@extends('layouts.pelamar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Detail Pengajuan Magang</h1>
            <p class="text-gray-600">Detail informasi pengajuan magang Anda</p>     
        </div>

        <!-- Status Badge -->
        <div class="mb-8">
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($lamaran->status === 'diterima') bg-green-100 text-green-800
                @elseif($lamaran->status === 'ditolak') bg-red-100 text-red-800
                @elseif($lamaran->status === 'revisi') bg-orange-100 text-orange-800
                @elseif($lamaran->status === 'magang_berjalan') bg-blue-100 text-blue-800
                @elseif($lamaran->status === 'magang_selesai') bg-gray-100 text-gray-800
                @else bg-yellow-100 text-yellow-800
                @endif">
                Status: {{ $lamaran->status_label }}
            </span>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Biodata Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Biodata</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                        <p class="text-gray-900">{{ $lamaran->nama }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-900">{{ $lamaran->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Asal Universitas</label>
                        <p class="text-gray-900">{{ $lamaran->asal_sekolah }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Jurusan</label>
                        <p class="text-gray-900">{{ $lamaran->jurusan }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Semester</label>
                        <p class="text-gray-900">{{ $lamaran->semester }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Magang Section -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Magang</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Periode Magang</label>
                        <p class="text-gray-900">
                            {{ \Carbon\Carbon::parse($lamaran->tanggal_mulai)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($lamaran->tanggal_selesai)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="mt-6 bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Dokumen</h2>
            <div class="space-y-4">
                <!-- Surat Pengantar -->
                @if($lamaran->surat_pengantar_path)
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">Surat Pengantar</h3>
                        <p class="text-sm text-gray-500">Surat pengantar dari institusi pendidikan</p>
                    </div>
                    <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'surat_pengantar']) }}" 
                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition">
                        <i class="fas fa-download mr-2"></i> Unduh
                    </a>
                </div>
                @endif

                <!-- CV -->
                @if($lamaran->cv_path)
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <div>
                        <h3 class="font-medium text-gray-900">Curriculum Vitae</h3>
                        <p class="text-sm text-gray-500">CV Anda</p>
                    </div>
                    <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'cv']) }}" 
                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition">
                        <i class="fas fa-download mr-2"></i> Unduh
                    </a>
                </div>
                @endif

                <!-- Surat Diterima -->
                @if($lamaran->status === 'diterima' && $lamaran->surat_diterima_path)
                <div class="flex items-center justify-between p-4 border rounded-lg bg-green-50">
                    <div>
                        <h3 class="font-medium text-green-900">Surat Penerimaan Magang</h3>
                        <p class="text-sm text-green-600">Surat balasan penerimaan magang</p>
                    </div>
                    <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'surat_diterima']) }}" 
                    class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition">
                        <i class="fas fa-download mr-2"></i> Unduh
                    </a>
                </div>
                @endif
        
                @if($lamaran->status === 'ditolak' && $lamaran->surat_ditolak_path)
                <!-- Surat Ditolak -->
                <div class="flex items-center justify-between p-4 border rounded-lg bg-red-50">
                    <div>
                        <h3 class="font-medium text-red-900">Surat Penolakan</h3>
                        <p class="text-sm text-red-600">Surat balasan penolakan magang</p>
                    </div>
                    <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'surat_ditolak']) }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition">
                        <i class="fas fa-download mr-2"></i> Unduh
                    </a>
                </div>
                @endif
        
                @if($lamaran->status === 'revisi' && $lamaran->catatan_revisi)
                <!-- Catatan Revisi -->
                <div class="p-4 border rounded-lg bg-orange-50">
                    <div>
                        <h3 class="font-medium text-orange-900">Catatan Revisi</h3>
                        <p class="mt-2 text-orange-600">{{ $lamaran->catatan_revisi }}</p>
                    </div>
                </div>
                @endif
        
                @if($lamaran->status === 'magang_selesai' && $lamaran->sertifikat_path)
                <!-- Sertifikat -->
                <div class="flex items-center justify-between p-4 border rounded-lg bg-gray-50">
                    <div>
                        <h3 class="font-medium text-gray-900">Sertifikat Magang</h3>
                        <p class="text-sm text-gray-600">Sertifikat penyelesaian magang</p>
                    </div>
                    <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'sertifikat']) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                        <i class="fas fa-download mr-2"></i> Unduh
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('pelamar.status') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection