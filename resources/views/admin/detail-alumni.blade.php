@extends('layouts.admin')

@section('title', 'Detail Alumni')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Alumni</h1>
        <a href="{{ route('admin.alumni') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Profile Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Biodata Alumni</h2>
                <div class="flex items-center space-x-2">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                        Alumni Magang
                    </span>
                    @if($alumnus->sertifikat_path)
                        <a href="{{ route('admin.alumni.download-sertifikat', $alumnus->id) }}>"
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-download mr-2"></i>
                            Download Sertifikat
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Profile Photo -->
                <div class="text-center">
                    <div class="mb-4">
                        @if($alumnus->user->biodata && $alumnus->user->biodata->profile_photo)
                            <img src="{{ asset('storage/' . $alumnus->user->biodata->profile_photo) }}"
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
                    <h3 class="text-xl font-semibold text-gray-800">{{ $alumnus->nama }}</h3>
                    <p class="text-gray-600">{{ $alumnus->email }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        Periode Magang:<br>
                        {{ \Carbon\Carbon::parse($alumnus->tanggal_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($alumnus->tanggal_selesai)->format('d M Y') }}
                    </p>
                </div>

                <!-- Personal Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                                <p class="mt-1 text-gray-900">{{ $alumnus->nama }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-600">Email</label>
                                <p class="mt-1 text-gray-900">{{ $alumnus->email }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                <p class="mt-1 text-gray-900">{{ $alumnus->user->biodata->jenis_kelamin ?? 'Tidak tersedia' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Akademik</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-600">Asal Universitas</label>
                                <p class="mt-1 text-gray-900">{{ $alumnus->asal_sekolah }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-600">Jurusan</label>
                                <p class="mt-1 text-gray-900">{{ $alumnus->jurusan }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <label class="block text-sm font-medium text-gray-600">Semester</label>
                                <p class="mt-1 text-gray-900">{{ $alumnus->user->biodata->semester ?? 'Tidak tersedia' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Dokumen</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if($alumnus->surat_pengantar_path)
                    <a href="{{ route('admin.pelamar.download', ['id' => $alumnus->id, 'type' => 'surat_pengantar']) }}"
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Surat Pengantar</h4>
                            <p class="text-sm text-gray-500">Klik untuk download</p>
                        </div>
                    </a>
                @endif

                @if($alumnus->cv_path)
                    <a href="{{ route('admin.pelamar.download', ['id' => $alumnus->id, 'type' => 'cv']) }}"
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-file-pdf text-red-500 text-2xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">CV</h4>
                            <p class="text-sm text-gray-500">Klik untuk download</p>
                        </div>
                    </a>
                @endif

                @if($alumnus->sertifikat_path)
                    <a href="{{ route('admin.pelamar.download', ['id' => $alumnus->id, 'type' => 'sertifikat']) }}"
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-certificate text-yellow-500 text-2xl mr-3"></i>
                        <div>
                            <h4 class="font-medium text-gray-900">Sertifikat Magang</h4>
                            <p class="text-sm text-gray-500">Klik untuk download</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection