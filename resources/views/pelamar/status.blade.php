@extends('layouts.pelamar')

@section('title', 'Status Lamaran')
@php
    $pengaturan = \App\Models\Pengaturan::first();
@endphp

@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold">Dashboard Pelamar 👋</h1>
        <p class="text-sm opacity-90 mt-1">Pantau dan kelola pengajuan magang kamu dengan mudah</p>
    </div>

    {{-- BUTTON --}}
@if(!$lamarans->count() || in_array($lamarans->first()->status, ['revisi','ditolak','magang_selesai']))

    @if($pengaturan && $pengaturan->magang_dibuka)

        <div>
            <a href="{{ route('pelamar.formulir') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">

                <i class="fas fa-plus mr-2"></i>

                {{ $lamarans->count() ? 'Ajukan Ulang' : 'Ajukan Lamaran' }}

            </a>
        </div>

    @else

        <div>
            <button 
                class="inline-flex items-center px-5 py-2.5 bg-gray-400 text-white rounded-lg cursor-not-allowed shadow-md"
                disabled>

                <i class="fas fa-lock mr-2"></i>

                Pendaftaran Ditutup

            </button>
        </div>

    @endif

@endif

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ([
            ['title'=>'Menunggu','count'=>$lamarans->where('status','pending')->count(),'color'=>'yellow','icon'=>'clock'],
            ['title'=>'Diterima','count'=>$lamarans->where('status','diterima')->count(),'color'=>'green','icon'=>'check'],
            ['title'=>'Ditolak','count'=>$lamarans->where('status','ditolak')->count(),'color'=>'red','icon'=>'times'],
            ['title'=>'Revisi','count'=>$lamarans->where('status','revisi')->count(),'color'=>'orange','icon'=>'edit'],
        ] as $stat)

        <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">{{ $stat['title'] }}</div>
                <div class="text-2xl font-bold">{{ $stat['count'] }}</div>
            </div>
            <div class="text-{{ $stat['color'] }}-500 text-2xl">
                <i class="fas fa-{{ $stat['icon'] }}"></i>
            </div>
        </div>

        @endforeach
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">

        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold">Riwayat Lamaran</h2>
            <p class="text-sm text-gray-500">Status pengajuan magang kamu</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Universitas</th>
                        <th class="px-4 py-3 text-left">Jurusan</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Posisi</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($lamarans as $lamaran)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3 font-medium">{{ $lamaran->nama }}</td>
                        <td class="px-4 py-3">{{ $lamaran->asal_sekolah }}</td>
                        <td class="px-4 py-3">{{ $lamaran->jurusan }}</td>

                        <td class="px-4 py-3 text-sm">
                            {{ \Carbon\Carbon::parse($lamaran->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($lamaran->tanggal_selesai)->format('d M Y') }}
                        </td>

                        <td class="px-4 py-3">
                            @if($lamaran->posisi)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                                    {{ $lamaran->posisi->nama_posisi }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">Belum ada</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs bg-{{ $lamaran->status_color }}-100 text-{{ $lamaran->status_color }}-700">
                                {{ $lamaran->status_label }}
                            </span>
                        </td>

                        <td class="px-4 py-3 space-x-2">

                            <a href="{{ route('pelamar.detail', $lamaran->id) }}" 
                               class="text-blue-600 hover:underline text-sm">
                                Detail
                            </a>

                            @if($lamaran->status === 'diterima' && $lamaran->surat_diterima_path)
                            <a href="{{ route('pelamar.download-surat', ['id'=>$lamaran->id,'type'=>'surat_diterima']) }}"
                               class="text-green-600 hover:underline text-sm">
                                Download
                            </a>
                            @endif

                            @if(in_array($lamaran->status, ['pending','revisi','ditolak']))
                            <form action="{{ route('pelamar.delete', $lamaran->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" 
                                        class="text-red-500 hover:underline text-sm">
                                    Hapus
                                </button>
                            </form>
                            @endif

                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-400">
                            <i class="fas fa-inbox text-3xl mb-2"></i><br>
                            Belum ada lamaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection