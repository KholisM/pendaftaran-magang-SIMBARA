{{-- resources/views/pelamar/formulir-closed.blade.php --}}
@extends('layouts.pelamar')

@section('title', 'Status Lamaran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 rounded-full mb-4">
                <i class="fas fa-check-circle text-3xl text-indigo-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Lamaran Terkirim</h1>
            <p class="text-gray-600">Anda telah mengajukan lamaran magang</p>
        </div>

        <!-- Informasi Lamaran -->
        <div class="bg-gray-50 rounded-xl p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Detail Lamaran</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                    <span class="text-gray-600">Tanggal Pengajuan</span>
                    <span class="font-medium">{{ $lamaran->created_at->format('d F Y') }}</span>
                </div>
                
                <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                    <span class="text-gray-600">Status</span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($lamaran->status == 'pending')
                            bg-yellow-100 text-yellow-800
                        @elseif($lamaran->status == 'diterima')
                            bg-green-100 text-green-800
                        @elseif($lamaran->status == 'ditolak')
                            bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($lamaran->status) }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                    <span class="text-gray-600">Divisi</span>
                    <span class="font-medium">{{ $lamaran->bagian_divisi }}</span>
                </div>
                
                <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                    <span class="text-gray-600">Periode Magang</span>
                    <span class="font-medium">
                        {{ \Carbon\Carbon::parse($lamaran->tanggal_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($lamaran->tanggal_selesai)->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Pesan Informasi -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Silakan pantau status lamaran Anda secara berkala. Kami akan menghubungi Anda melalui email jika ada pembaruan status.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection