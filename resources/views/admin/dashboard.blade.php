@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

<div class="space-y-8">

    <!-- HERO -->
    <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 rounded-3xl p-8 text-white shadow-2xl overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-sm opacity-80">Dashboard Admin</h2>
            <h1 class="text-4xl font-bold mt-1">{{ $admin->name ?? 'Admin' }}</h1>
            <p class="mt-2 text-white/80">Pantau dan kelola seluruh aktivitas magang</p>
        </div>

        <!-- blur circle -->
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
    </div>

    <!-- STAT GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- CARD -->
        <div class="relative bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-lg border border-white/40 hover:scale-[1.02] transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Menunggu</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $statistics['menunggu_konfirmasi'] }}</h2>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="relative bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:scale-[1.02] transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Disetujui</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $statistics['permohonan_disetujui'] }}</h2>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>

        <div class="relative bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:scale-[1.02] transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Ditolak</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $statistics['permohonan_ditolak'] }}</h2>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>

        <div class="relative bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:scale-[1.02] transition">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm">Magang Berjalan</p>
            <h2 class="text-3xl font-bold text-gray-800">
                {{ $statistics['magang_berjalan'] }}
            </h2>
        </div>

        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
            <i class="fas fa-user-clock"></i>
        </div>
    </div>
</div>

<div class="relative bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:scale-[1.02] transition">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm">Alumni</p>
            <h2 class="text-3xl font-bold text-gray-800">
                {{ $statistics['magang_selesai'] }}
            </h2>
        </div>

        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-600">
            <i class="fas fa-user-graduate"></i>
        </div>
    </div>
</div>

        <div class="relative bg-white/70 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:scale-[1.02] transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Total</p>
                    <h2 class="text-3xl font-bold text-gray-800">{{ $statistics['total_permohonan'] }}</h2>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-file"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- LIST STYLE (GANTI TABLE JADI CARD LIST) -->
    <div class="space-y-4">

        <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Permohonan Terbaru</h3>
            <a href="{{ route('admin.pelamar') }}" class="text-blue-600 text-sm hover:underline">
                Lihat Semua →
            </a>
        </div>

        @forelse ($recentApplications as $application)
        <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-md transition">

            <div>
                <h4 class="font-semibold text-gray-800">{{ $application->nama }}</h4>
                <p class="text-sm text-gray-500">{{ $application->email }}</p>
                <p class="text-sm text-gray-400 mt-1">
                    {{ $application->asal_sekolah }} • {{ $application->jurusan }}
                </p>
            </div>

            <div class="mt-3 md:mt-0 text-sm text-gray-600">
                <div>{{ $application->created_at->format('d M Y') }}</div>
                <div class="text-xs text-gray-400">
                    {{ \Carbon\Carbon::parse($application->tanggal_mulai)->format('d M Y') }} - 
                    {{ \Carbon\Carbon::parse($application->tanggal_selesai)->format('d M Y') }}
                </div>
            </div>

            <div class="mt-3 md:mt-0">
                <a href="{{ route('admin.detail.pelamar', $application->id) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Detail
                </a>
            </div>

        </div>
        @empty
        <div class="text-center text-gray-400 py-10">
            Belum ada data 😴
        </div>
        @endforelse

    </div>

</div>

@endsection