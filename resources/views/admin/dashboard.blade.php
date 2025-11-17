@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
        <h3 class="text-xl font-light">Selamat Datang,</h3>
        <h4 class="text-3xl font-bold">{{ $admin->name ?? 'Admin' }}</h4>
        <p class="mt-2 text-blue-100">Kelola permohonan magang dan pantau progress peserta magang</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Row 1 -->
        <div class="bg-white rounded-lg shadow-sm p-6 transform transition-transform hover:scale-105">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-medium mb-1">Menunggu Konfirmasi</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['menunggu_konfirmasi'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transform transition-transform hover:scale-105">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-medium mb-1">Permohonan Disetujui</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['permohonan_disetujui'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transform transition-transform hover:scale-105">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-times-circle text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-medium mb-1">Permohonan Ditolak</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['permohonan_ditolak'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transform transition-transform hover:scale-105">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-edit text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-medium mb-1">Revisi Permohonan</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['revisi_permohonan'] }}</p>
                </div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="bg-white rounded-lg shadow-sm p-6 transform transition-transform hover:scale-105">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-indigo-100 text-indigo-600">
                    <i class="fas fa-user-graduate text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-medium mb-1">Magang Berjalan</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['magang_berjalan'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transform transition-transform hover:scale-105">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-emerald-100 text-emerald-600">
                    <i class="fas fa-flag-checkered text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-medium mb-1">Magang Selesai</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['magang_selesai'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 transform transition-transform hover:scale-105 lg:col-span-2">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm font-medium mb-1">Total Permohonan</h2>
                    <p class="text-2xl font-bold text-gray-800">{{ $statistics['total_permohonan'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Permohonan Menunggu Konfirmasi</h3>
            <a href="{{ route('admin.pelamar') }}" class="text-blue-600 hover:text-blue-700 font-medium transition">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-blue-600 text-white">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Asal Universitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Jurusan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase">Periode Magang</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($recentApplications as $application)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $application->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $application->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $application->asal_sekolah }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $application->jurusan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $application->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <div class="flex flex-col">
                                <span class="text-gray-900 font-medium">Mulai: {{ \Carbon\Carbon::parse($application->tanggal_mulai)->format('d M Y') }}</span>
                                <span class="text-gray-500">Selesai: {{ \Carbon\Carbon::parse($application->tanggal_selesai)->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('admin.detail.pelamar', $application->id) }}" 
                               class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-blue-600 transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada permohonan yang menunggu konfirmasi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection