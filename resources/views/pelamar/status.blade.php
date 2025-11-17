@extends('layouts.pelamar')

@section('title', 'Status Lamaran')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Beranda</h1>
            <p class="text-sm text-gray-600 mt-1">Selamat Datang! Silahkan mengajukan lamaran.</p>
        </div>
        <!-- Info Message -->
        @if(session('info'))
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mb-6 shadow-md animate-fade-in relative">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                {{ session('info') }}
            </div>
            <button class="absolute top-0 right-0 mt-4 mr-4 text-blue-700 hover:text-blue-900" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif

        <!-- Conditional Button -->
        @if(!$lamarans->count() || in_array($lamarans->first()->status, ['revisi','ditolak','magang_selesai']))
        <a href="{{ route('pelamar.formulir') }}" 
           class="flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">
            <i class="fas fa-plus mr-2"></i>
            {{ $lamarans->count() ? 'Ajukan Lamaran Ulang' : 'Ajukan Lamaran' }}
        </a>
        @endif
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-md animate-fade-in relative">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
        <button class="absolute top-0 right-0 mt-4 mr-4 text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Stats Section -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ([
            ['title' => 'Menunggu', 'count' => $lamarans->where('status', 'pending')->count(), 'color' => 'yellow'],
            ['title' => 'Diterima', 'count' => $lamarans->where('status', 'diterima')->count(), 'color' => 'green'],
            ['title' => 'Ditolak', 'count' => $lamarans->where('status', 'ditolak')->count(), 'color' => 'red'],
            ['title' => 'revisi', 'count' => $lamarans->where('status', 'revisi')->count(), 'color' => 'orange'],
        ] as $stat)
        <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-{{ $stat['color'] }}-500">
            <div class="text-sm text-gray-600">{{ $stat['title'] }}</div>
            <div class="text-2xl font-bold text-gray-900">{{ $stat['count'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Status Pengajuan Magang -->
    <div class="mt-8">
        <h2 class="text-2xl font-semibold text-gray-900">Status Pengajuan Magang</h2>
        <p class="text-sm text-gray-600">Pantau status pengajuan magang Anda di sini</p>
    </div>
    <div class="mt-4 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white sticky top-0">
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Asal Universitas</th>
                        <th class="px-6 py-3 text-left">Jurusan</th>
                        <th class="px-6 py-3 text-left">Periode Magang</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($lamarans as $lamaran)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-900">{{ $lamaran->nama }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $lamaran->asal_sekolah }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $lamaran->jurusan }}</td>
                        <td class="px-6 py-4 text-gray-900">
                            {{ Carbon\Carbon::parse($lamaran->tanggal_mulai)->locale('id')->isoFormat('D MMM Y') }} -
                            {{ Carbon\Carbon::parse($lamaran->tanggal_selesai)->locale('id')->isoFormat('D MMM Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-{{ $lamaran->status_color }}-100 text-{{ $lamaran->status_color }}-800">
                                {{ $lamaran->status_label }}
                            </span>
                        </td>                        
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('pelamar.detail', $lamaran->id) }}" 
                                   class="inline-flex items-center px-3 py-1 text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 transition">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                @if($lamaran->status === 'diterima' && $lamaran->surat_diterima_path)
                                    <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'surat_diterima']) }}" 
                                       class="inline-flex items-center px-3 py-1 text-green-700 bg-green-100 rounded-md hover:bg-green-200 transition">
                                        <i class="fas fa-download mr-1"></i> Unduh Surat
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">Belum ada pengajuan lamaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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