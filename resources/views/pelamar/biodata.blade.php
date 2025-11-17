@extends('layouts.pelamar')

@section('title', 'Biodata Pelamar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Biodata Pelamar</h1>
            <p class="text-sm text-gray-600 mt-1">Selamat datang, {{ $user->name }}!</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('pelamar.edit-biodata') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-user-edit mr-2"></i>
                Edit Profil
            </a>
            <a href="{{ route('pelamar.formulir') }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                Selanjutnya
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 animate-fade-in relative">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
            <button class="absolute top-0 right-0 mt-4 mr-4 text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
                <div class="text-center">
                    <div class="mb-4">
                        @if($user->biodata && $user->biodata->profile_photo)
                            <!-- Jika ada foto, tampilkan fotonya -->
                            <img src="{{ asset('storage/' . $user->biodata->profile_photo) }}" 
                                alt="Profile Photo" 
                                class="w-48 h-48 rounded-full mx-auto object-cover border-4 border-gray-200 shadow-lg">
                        @else
                            <!-- Jika tidak ada foto, tampilkan ikon default -->
                            <div class="w-48 h-48 rounded-full mx-auto bg-gray-200 flex items-center justify-center border-4 border-gray-300">
                                <span class="text-6xl text-gray-400">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-university text-purple-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Nama</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->name ?? 'Belum diisi' }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-envelope text-blue-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-gray-500">Email</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Detail Information -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 gap-6">
                <!-- Academic Information Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="fas fa-graduation-cap text-blue-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Akademik</h3>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- IPK Stats -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-chart-line text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">IPK</p>
                                        <p class="text-2xl font-bold text-gray-800">{{ $user->biodata->ipk ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Semester Stats -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-user-graduate text-green-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Semester</p>
                                        <p class="text-2xl font-bold text-gray-800">{{ $user->biodata->semester ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-4">
                            <!-- Program Studi Info -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <i class="fas fa-book text-purple-500"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-500">Program Studi</p>
                                    <p class="text-base font-semibold text-gray-800">{{ $user->biodata->jurusan ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- University Info -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <i class="fas fa-university text-yellow-500"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-gray-500">Universitas/Sekolah</p>
                                    <p class="text-base font-semibold text-gray-800">{{ $user->biodata->asal_sekolah ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-pink-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Informasi Pribadi</h3>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom Kiri -->
                            <div class="space-y-4">
                                <!-- Tempat & Tanggal Lahir -->
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-birthday-cake text-green-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-500">Tempat & Tanggal Lahir</p>
                                        <p class="text-base font-semibold text-gray-800">
                                            @if($user->biodata && $user->biodata->tempat_lahir && $user->biodata->tanggal_lahir)
                                                {{ $user->biodata->tempat_lahir }}, 
                                                {{ \Carbon\Carbon::parse($user->biodata->tanggal_lahir)->isoFormat('D MMMM Y') }}
                                            @else
                                                Belum diisi
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Jenis Kelamin -->
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                        <i class="fas fa-venus-mars text-pink-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-500">Jenis Kelamin</p>
                                        <p class="text-base font-semibold text-gray-800">
                                            {{ $user->biodata->jenis_kelamin ?? 'Belum diisi' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kolom Kanan -->
                            <div class="space-y-4">
                                <!-- Agama -->
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                                        <i class="fas fa-pray text-purple-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-500">Agama</p>
                                        <p class="text-base font-semibold text-gray-800">
                                            {{ $user->biodata->agama ?? 'Belum diisi' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Alamat -->
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <i class="fas fa-home text-yellow-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm text-gray-500">Alamat</p>
                                        <p class="text-base font-semibold text-gray-800">
                                            {{ $user->biodata->alamat ?? 'Belum diisi' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Completion Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Kelengkapan Profil</h3>
                    </div>
                    
                    <div class="p-6">
                        @php
                            $fields = ['name', 'email', 'asal_sekolah', 'jurusan', 'semester', 'jenis_kelamin', 'ipk'];
                            $filled = collect($fields)->filter(function($field) use ($user) {
                                return $field === 'name' || $field === 'email' 
                                    ? !empty($user->$field) 
                                    : !empty($user->biodata->$field ?? '');
                            })->count();
                            $percentage = round(($filled / count($fields)) * 100);
                        @endphp

                        <div class="mb-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-500">Progress</span>
                                <span class="text-sm font-semibold text-gray-700">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-500" 
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        @if($percentage < 100)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Profil Anda belum lengkap. Lengkapi profil untuk meningkatkan peluang diterima magang.
                                    </p>
                                    <div class="mt-3">
                                        <a href="{{ route('pelamar.edit-biodata') }}" 
                                           class="inline-flex items-center px-3 py-1.5 border border-yellow-400 text-yellow-700 bg-yellow-50 hover:bg-yellow-100 rounded-md text-sm font-medium transition-colors">
                                            <i class="fas fa-user-edit mr-2"></i>
                                            Lengkapi Profil
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        Profil Anda sudah lengkap! Anda siap untuk mengajukan lamaran magang.
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
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.5s ease-out;
}
</style>
@endsection