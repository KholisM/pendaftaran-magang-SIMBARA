@extends('layouts.admin')

@section('title', 'Detail Pelamar')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Detail Pelamar</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Biodata Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Biodata Pelamar</h2>
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-{{ $pelamar->status_color }}-100 text-{{ $pelamar->status_color }}-800">
                    {{ $pelamar->status_label }}
                </span>
                
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Profile Photo Column -->
                <div class="text-center">
                    <div class="mb-4">
                        @if($pelamar->biodata && $pelamar->biodata->profile_photo)
                            <img src="{{ asset('storage/' . $pelamar->biodata->profile_photo) }}" 
                                 alt="Profile Photo" 
                                 class="w-48 h-48 rounded-full mx-auto object-cover border-4 border-gray-200 shadow-lg">
                        @else
                            <div class="w-48 h-48 rounded-full mx-auto bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                <span class="text-6xl text-gray-400">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        @endif
                    </div>                    
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $pelamar->user->name }}</h3>
                        <p class="text-gray-600">{{ $pelamar->user->email }}</p>
                        <p class="text-sm text-gray-500 mt-2">
                            Last Updated: {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}
                        </p>
                    </div>
                </div>

                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Pribadi</h3>
                        @if($pelamar->user->biodata)
                            <div class="grid grid-cols-1 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Tempat Lahir</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->tempat_lahir ?? 'Belum diisi' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Tanggal Lahir</label>
                                    <p class="mt-1 text-gray-900">
                                        {{ $pelamar->user->biodata->tanggal_lahir ? \Carbon\Carbon::parse($pelamar->user->biodata->tanggal_lahir)->format('d F Y') : 'Belum diisi' }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->jenis_kelamin ?? 'Belum diisi' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Agama</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->agama ?? 'Belum diisi' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Alamat</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->alamat ?? 'Belum diisi' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Pelamar belum membuat biodata
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi Akademik</h3>
                        @if($pelamar->user->biodata)
                            <div class="grid grid-cols-1 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Asal Universitas</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->asal_sekolah ?? 'Belum diisi' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Jurusan</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->jurusan ?? 'Belum diisi' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">Semester</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->semester ?? 'Belum diisi' }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <label class="block text-sm font-medium text-gray-600">IPK</label>
                                    <p class="mt-1 text-gray-900">{{ $pelamar->user->biodata->ipk ?? 'Belum diisi' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Pelamar belum membuat biodata
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Magang Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6 p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Detail Magang</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Tanggal Mulai -->
            <div class="bg-gray-100 p-4 rounded-lg flex items-center">
                <div class="w-12 h-12 bg-blue-500 text-white flex items-center justify-center rounded-full">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Tanggal Mulai</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($pelamar->tanggal_mulai)->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>

            <!-- Tanggal Selesai -->
            <div class="bg-gray-100 p-4 rounded-lg flex items-center">
                <div class="w-12 h-12 bg-red-500 text-white flex items-center justify-center rounded-full">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Tanggal Selesai</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($pelamar->tanggal_selesai)->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Dokumen Section -->
        <div class="bg-gray-100 p-4 rounded-lg mt-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Dokumen</h3>
            <div class="flex flex-col space-y-2">
                @if($pelamar->surat_pengantar_path)
                    <a href="{{ route('admin.pelamar.download', ['id' => $pelamar->id, 'type' => 'surat_pengantar']) }}" 
                    class="text-blue-600 hover:text-blue-800 flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        <span>Surat Pengantar</span>
                    </a>
                @endif
                @if($pelamar->cv_path)
                    <a href="{{ route('admin.pelamar.download', ['id' => $pelamar->id, 'type' => 'cv']) }}" 
                    class="text-blue-600 hover:text-blue-800 flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        <span>CV</span>
                    </a>
                @endif
            </div>
        </div>
    </div>


    <!-- Update Status Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Update Status Lamaran</h2>
                    <p class="text-sm text-gray-500 mt-1">Perbarui status lamaran magang beserta dokumen pendukung</p>
                </div>
                <!-- Current Status Badge -->
                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-{{ $pelamar->status_color }}-100 text-{{ $pelamar->status_color }}-800">
                    Status Saat Ini: {{ $pelamar->status_label }}
                </span>                
            </div>
    
            <form action="{{ route('admin.pelamar.update-status', $pelamar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <!-- Status Selection -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Lamaran</label>
                        <select id="status" name="status" 
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="pending" {{ $pelamar->status == 'pending' ? 'selected' : '' }}>
                                Menunggu Konfirmasi
                            </option>
                            <option value="diterima" {{ $pelamar->status == 'diterima' ? 'selected' : '' }}>
                                Diterima
                            </option>
                            <option value="ditolak" {{ $pelamar->status == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                            <option value="revisi" {{ $pelamar->status == 'revisi' ? 'selected' : '' }}>
                                Perlu Revisi
                            </option>
                            <option value="magang_berjalan" {{ $pelamar->status == 'magang_berjalan' ? 'selected' : '' }}>
                                Magang Berjalan
                            </option>
                            <option value="magang_selesai" {{ $pelamar->status == 'magang_selesai' ? 'selected' : '' }}>
                                Magang Selesai
                            </option>
                        </select>
                    </div>
    
                    <!-- Dynamic Document Sections -->
                    <!-- Surat Diterima -->
                    <div id="suratDiterimaSection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Surat Balasan Diterima
                        </label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="surat_diterima" accept=".pdf" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                                          file:rounded-full file:border-0 file:text-sm file:font-semibold 
                                          file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Upload surat balasan penerimaan magang (PDF)
                        </p>
                    </div>
    
                    <!-- Surat Ditolak -->
                    <div id="suratDitolakSection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Surat Balasan Ditolak
                        </label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="surat_ditolak" accept=".pdf" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                                          file:rounded-full file:border-0 file:text-sm file:font-semibold 
                                          file:bg-red-50 file:text-red-700 hover:file:bg-red-100"/>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Upload surat penolakan magang (PDF)
                        </p>
                    </div>
    
                    <!-- Catatan Revisi -->
                    <div id="revisiSection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Revisi
                        </label>
                        <textarea name="catatan_revisi" rows="4" 
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Tuliskan catatan revisi yang diperlukan..."></textarea>
                        <p class="mt-1 text-sm text-gray-500">
                            Berikan detail revisi yang diperlukan
                        </p>
                    </div>
    
                    <!-- Sertifikat -->
                    <div id="sertifikatSection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sertifikat Magang
                        </label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="sertifikat" accept=".pdf" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                                          file:rounded-full file:border-0 file:text-sm file:font-semibold 
                                          file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100"/>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Upload sertifikat magang (PDF)
                        </p>
                    </div>
    
                    <!-- Buttons -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.pelamar') }}" 
                           class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 
                                  focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 
                                  transition-colors">
                            Kembali
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
                                       transition-colors inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" 
                                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
                                      clip-rule="evenodd" />
                            </svg>
                            Update Status
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the status select element
        const statusSelect = document.getElementById('status');
        
        // Add change event listener
        statusSelect.addEventListener('change', function() {
            updateFormSections(this.value);
        });
        
        // Initial update based on current status
        updateFormSections(statusSelect.value);
    });
    
    function updateFormSections(status) {
        // Hide all sections first
        document.getElementById('suratDiterimaSection').classList.add('hidden');
        document.getElementById('suratDitolakSection').classList.add('hidden');
        document.getElementById('revisiSection').classList.add('hidden');
        document.getElementById('sertifikatSection').classList.add('hidden');
        
        // Show relevant section based on status
        switch(status) {
            case 'diterima':
                document.getElementById('suratDiterimaSection').classList.remove('hidden');
                break;
            case 'ditolak':
                document.getElementById('suratDitolakSection').classList.remove('hidden');
                break;
            case 'revisi':
                document.getElementById('revisiSection').classList.remove('hidden');
                break;
            case 'magang_selesai':
                document.getElementById('sertifikatSection').classList.remove('hidden');
                break;
        }
    }
    </script>
    @endpush
    @endsection