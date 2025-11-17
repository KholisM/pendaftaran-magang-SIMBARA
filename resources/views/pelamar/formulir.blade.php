@extends('layouts.pelamar')

@section('title', 'Formulir Lamaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header dengan Background Gradient -->
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Formulir Pendaftaran Magang</h1>
        <p class="text-gray-600">Dinas Komunikasi dan Informatika</p>
        <div class="w-20 h-1 bg-gradient-to-r from-indigo-500 to-blue-500 mx-auto mt-4 rounded-full"></div>
    </div>

    <!-- Notifikasi dengan Animasi -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 animate-fade-in flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 animate-fade-in flex items-center">
            <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 animate-fade-in">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                <span class="font-semibold">Mohon perbaiki kesalahan berikut:</span>
            </div>
            <ul class="list-disc list-inside ml-6">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Card Formulir dengan Shadow dan Border yang Lebih Menarik -->
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200 max-w-5xl mx-auto">
        <!-- Progress Steps dengan spacing yang lebih baik -->
        <div class="flex items-center justify-center mb-12 px-4">
            <div class="flex items-center w-full max-w-4xl justify-between">
                <!-- Step 1: Data Diri -->
                <div class="flex flex-col items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-14 w-14 border-2 border-indigo-600 bg-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-white">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                    </div>
                    <div class="text-center mt-4">
                        <span class="text-xs font-semibold uppercase text-indigo-600 block">Langkah 1</span>
                        <span class="text-sm font-medium text-gray-700">Data Diri</span>
                    </div>
                </div>

                <!-- Connector Line 1 -->
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-indigo-600 mx-8 mt-7"></div>

                <!-- Step 2: Magang -->
                <div class="flex flex-col items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-14 w-14 border-2 border-indigo-600 bg-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-white">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                    </div>
                    <div class="text-center mt-4">
                        <span class="text-xs font-semibold uppercase text-indigo-600 block">Langkah 2</span>
                        <span class="text-sm font-medium text-gray-700">Magang</span>
                    </div>
                </div>

                <!-- Connector Line 2 -->
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-indigo-600 mx-8 mt-7"></div>

                <!-- Step 3: Dokumen -->
                <div class="flex flex-col items-center relative">
                    <div class="rounded-full transition duration-500 ease-in-out h-14 w-14 border-2 border-indigo-600 bg-indigo-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="text-white">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <div class="text-center mt-4">
                        <span class="text-xs font-semibold uppercase text-indigo-600 block">Langkah 3</span>
                        <span class="text-sm font-medium text-gray-700">Dokumen</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="w-full h-px bg-gray-200 mb-8"></div>

        <form action="{{ route('pelamar.formulir.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($user->biodata)
                <!-- Section: Data Diri -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-user-circle mr-3 text-indigo-600"></i>
                        Data Diri
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" name="nama" value="{{ $user->name }}" 
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 group-hover:border-indigo-400"
                                       placeholder="Masukkan nama lengkap" readonly>
                                <span class="absolute right-3 top-2 text-indigo-500">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="relative">
                                <input type="email" name="email" value="{{ $user->email }}" 
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 group-hover:border-indigo-400"
                                       placeholder="Masukkan email" readonly>
                                <span class="absolute right-3 top-2 text-indigo-500">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Asal Universitas/Sekolah -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Asal Universitas/Sekolah</label>
                            <div class="relative">
                                <input type="text" name="asal_sekolah" value="{{ $user->biodata->asal_sekolah }}" 
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 group-hover:border-indigo-400"
                                       placeholder="Masukkan asal universitas/sekolah" readonly>
                                <span class="absolute right-3 top-2 text-indigo-500">
                                    <i class="fas fa-university"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Jurusan -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                            <div class="relative">
                                <input type="text" name="jurusan" value="{{ $user->biodata->jurusan }}" 
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 group-hover:border-indigo-400"
                                       placeholder="Masukkan jurusan" readonly>
                                <span class="absolute right-3 top-2 text-indigo-500">
                                    <i class="fas fa-graduation-cap"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Semester -->
                        <div class="group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                            <div class="relative">
                                <input type="number" name="semester" value="{{ old('semester') }}" 
                                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 group-hover:border-indigo-400"
                                       placeholder="Masukkan semester" required>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg mb-6 animate-fade-in">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <p>Anda belum mengisi biodata. Silakan isi biodata terlebih dahulu.</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('pelamar.edit-biodata') }}" 
                           class="inline-flex items-center px-3 py-1.5 border border-yellow-500 text-yellow-700 bg-yellow-100 hover:bg-yellow-200 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-user-edit mr-2"></i>
                            Isi Biodata Terlebih Dahulu
                        </a>
                    </div>
                </div>
            @endif

            <!-- Section: Informasi Magang -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-briefcase mr-3 text-indigo-600"></i>
                    Informasi Magang
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Mulai -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Magang</label>
                        <div class="relative">
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 group-hover:border-indigo-400"
                                   required>
                        </div>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai Magang</label>
                        <div class="relative">
                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200 group-hover:border-indigo-400"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Section: Upload Dokumen -->
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-file-upload mr-3 text-indigo-600"></i>
                    Upload Dokumen
                </h2>
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Surat Pengantar -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Surat Pengantar
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed border-indigo-300 hover:border-indigo-500 rounded-lg cursor-pointer transition-all group-hover:border-indigo-400">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <i class="fas fa-file-pdf text-3xl text-indigo-500 mb-2"></i>
                                        <p class="text-sm text-gray-500">Upload Surat Pengantar (PDF)</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik atau drag & drop file di sini</p>
                                    </div>
                                    <input type="file" name="surat_pengantar" accept=".pdf" class="hidden" required>
                                </label>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format file: PDF, maksimal 2MB
                        </p>
                    </div>
    
                    <!-- CV -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Curriculum Vitae (CV)
                            <span class="text-gray-500 text-xs">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 hover:border-indigo-500 rounded-lg cursor-pointer transition-all group-hover:border-indigo-400">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <i class="fas fa-file-alt text-3xl text-gray-400 mb-2 group-hover:text-indigo-500"></i>
                                        <p class="text-sm text-gray-500">Upload CV (PDF)</p>
                                        <p class="text-xs text-gray-400 mt-1">Klik atau drag & drop file di sini</p>
                                    </div>
                                    <input type="file" name="cv" accept=".pdf" class="hidden">
                                </label>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format file: PDF, maksimal 2MB
                        </p>
                    </div>
                </div>
            </div>

    
            <!-- Tombol Submit dengan Loading State -->
            <div class="flex justify-end mt-8">
                <button type="submit" 
                        class="group relative px-8 py-3 bg-gradient-to-r from-indigo-600 to-blue-500 text-white rounded-lg hover:from-indigo-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 transform hover:scale-[1.02]">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <span class="ml-6">Submit Lamaran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Tambahkan Style -->
    <style>
        /* Animasi Fade In */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    
        /* Custom File Input Styling */
        input[type="file"]::file-selector-button {
            display: none;
        }
    
        /* Hover Effects */
        .group:hover .group-hover\:border-indigo-400 {
            border-color: #000000;
        }
    
        .group:hover .group-hover\:text-indigo-500 {
            color: #1f3bf0;
        }
    
        /* Progress Steps Animation */
        .progress-step-active {
            @apply bg-indigo-600 border-indigo-600;
        }
    
        .progress-step-active + .absolute {
            @apply text-indigo-600;
        }
    </style>
    
    <!-- JavaScript untuk File Upload Preview -->
    <script>
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', (e) => {
                const fileName = e.target.files[0]?.name;
                if (fileName) {
                    const parent = e.target.closest('.flex');
                    const textElement = parent.querySelector('p.text-sm');
                    textElement.textContent = fileName;
                }
            });
        });
    </script>
@endsection