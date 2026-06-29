@extends('layouts.pelamar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- HEADER -->
        <div class="bg-white rounded-xl shadow-sm p-6 border">
            <h1 class="text-2xl font-bold text-gray-900">Detail Pengajuan Magang</h1>
            <p class="text-gray-500 mt-1">Detail informasi pengajuan magang Anda</p>

            <div class="mt-4">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold
                    @if($lamaran->status === 'diterima') bg-green-100 text-green-800
                    @elseif($lamaran->status === 'ditolak') bg-red-100 text-red-800
                    @elseif($lamaran->status === 'revisi') bg-orange-100 text-orange-800
                    @elseif($lamaran->status === 'magang_berjalan') bg-blue-100 text-blue-800
                    @elseif($lamaran->status === 'magang_selesai') bg-gray-100 text-gray-800
                    @else bg-yellow-100 text-yellow-800
                    @endif">
                    {{ $lamaran->status_label }}
                </span>
            </div>
        </div>

        <!-- PENEMPATAN POSISI -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Penempatan Posisi</h2>

            @if($lamaran->posisi)
                <div class="flex items-center justify-between p-4 rounded-lg bg-green-50 border border-green-100">
                    <div>
                        <p class="text-sm text-green-700">Posisi Magang</p>
                        <p class="text-lg font-semibold text-green-900">
                            {{ $lamaran->posisi->nama_posisi }}
                        </p>
                    </div>

                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                        Terisi
                    </span>
                </div>
            @else
                <div class="p-4 rounded-lg bg-gray-50 border">
                    <p class="text-gray-500 italic">Belum ada penempatan posisi magang.</p>
                </div>
            @endif
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- BIODATA -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Biodata</h2>

                <div class="space-y-3 text-sm">
                    @foreach([
                        'Nama Lengkap' => $lamaran->nama,
                        'Email' => $lamaran->email,
                        'Asal Universitas' => $lamaran->asal_sekolah,
                        'Jurusan' => $lamaran->jurusan,
                        'Semester' => $lamaran->semester
                    ] as $label => $value)
                        <div>
                            <p class="text-gray-500">{{ $label }}</p>
                            <p class="text-gray-900 font-medium">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- DETAIL MAGANG -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Magang</h2>

                <div class="text-sm space-y-3">
                    <div>
                        <p class="text-gray-500">Periode Magang</p>
                        <p class="text-gray-900 font-medium">
                            {{ \Carbon\Carbon::parse($lamaran->tanggal_mulai)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($lamaran->tanggal_selesai)->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- DOKUMEN -->
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-5">Dokumen</h2>

            <div class="space-y-3">

                @foreach([
                    [
                        'title' => 'Surat Pengantar',
                        'desc' => 'Surat dari institusi pendidikan',
                        'file' => $lamaran->surat_pengantar_path,
                        'type' => 'surat_pengantar',
                        'color' => 'blue'
                    ],
                    [
                        'title' => 'Curriculum Vitae',
                        'desc' => 'CV Anda',
                        'file' => $lamaran->cv_path,
                        'type' => 'cv',
                        'color' => 'blue'
                    ],
                ] as $doc)
                    @if($doc['file'])
                        <div class="flex items-center justify-between p-4 border rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $doc['title'] }}</p>
                                <p class="text-sm text-gray-500">{{ $doc['desc'] }}</p>
                            </div>

                            <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => $doc['type']]) }}"
                               class="px-4 py-2 text-sm rounded-md bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                Download
                            </a>
                        </div>
                    @endif
                @endforeach

                @if($lamaran->status === 'diterima' && $lamaran->surat_diterima_path)
                    <div class="flex items-center justify-between p-4 border rounded-lg bg-green-50">
                        <div>
                            <p class="font-medium text-green-900">Surat Penerimaan</p>
                            <p class="text-sm text-green-700">Surat diterima magang</p>
                        </div>

                        <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'surat_diterima']) }}"
                           class="px-4 py-2 text-sm rounded-md bg-green-100 text-green-700 hover:bg-green-200">
                            Download
                        </a>
                    </div>
                @endif

                @if($lamaran->status === 'ditolak' && $lamaran->surat_ditolak_path)
                    <div class="flex items-center justify-between p-4 border rounded-lg bg-red-50">
                        <div>
                            <p class="font-medium text-red-900">Surat Penolakan</p>
                            <p class="text-sm text-red-700">Surat tidak diterima</p>
                        </div>

                        <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'surat_ditolak']) }}"
                           class="px-4 py-2 text-sm rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                            Download
                        </a>
                    </div>
                @endif

                @if($lamaran->status === 'revisi' && $lamaran->catatan_revisi)
                    <div class="p-4 border rounded-lg bg-orange-50">
                        <p class="font-medium text-orange-900">Catatan Revisi</p>
                        <p class="text-sm text-orange-700 mt-1">{{ $lamaran->catatan_revisi }}</p>
                    </div>
                @endif

                @if($lamaran->status === 'magang_selesai' && $lamaran->sertifikat_path)
                    <div class="flex items-center justify-between p-4 border rounded-lg bg-gray-50">
                        <div>
                            <p class="font-medium text-gray-900">Sertifikat</p>
                            <p class="text-sm text-gray-500">Sertifikat selesai magang</p>
                        </div>

                        <a href="{{ route('pelamar.download-surat', ['id' => $lamaran->id, 'type' => 'sertifikat']) }}"
                           class="px-4 py-2 text-sm rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300">
                            Download
                        </a>
                    </div>
                @endif

            </div>
        </div>

        <!-- BACK -->
        <div>
            <a href="{{ route('pelamar.status') }}"
               class="inline-flex items-center px-4 py-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                ← Kembali
            </a>
        </div>

    </div>
</div>
@endsection