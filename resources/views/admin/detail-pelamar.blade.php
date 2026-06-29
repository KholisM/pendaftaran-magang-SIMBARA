@extends('layouts.admin')

@section('title', 'Detail Pelamar')

@section('content')
<div class="container mx-auto px-4">

    <h1 class="text-3xl font-bold mb-6 text-gray-800">Detail Pelamar</h1>

    {{-- ================= BIODATA PELAMAR ================= --}}
    <div class="bg-white rounded-xl shadow-lg mb-6">
        <div class="p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Biodata Pelamar</h2>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            @php $b = $pelamar->user->biodata; @endphp

            {{-- FOTO & AKUN --}}
            <div class="text-center">
                @if($b && $b->profile_photo)
                    <img src="{{ asset('storage/'.$b->profile_photo) }}"
                         class="w-40 h-40 mx-auto rounded-full object-cover border-4 border-gray-200 shadow">
                @else
                    <div class="w-40 h-40 mx-auto rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-user text-5xl text-gray-400"></i>
                    </div>
                @endif

                <h3 class="mt-4 text-xl font-semibold text-gray-800">
                    {{ $pelamar->user->name }}
                </h3>
                <p class="text-gray-500">{{ $pelamar->user->email }}</p>

                <div class="mt-3">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        bg-{{ $pelamar->status_color }}-100
                        text-{{ $pelamar->status_color }}-800">
                        {{ $pelamar->status_label }}
                    </span>
                </div>
            </div>

            {{-- DATA PRIBADI --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                    Informasi Pribadi
                </h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Tempat, Tgl Lahir</span>
                        <span class="font-medium text-gray-800">
                            {{ $b->tempat_lahir ?? '-' }},
                            {{ $b && $b->tanggal_lahir ? \Carbon\Carbon::parse($b->tanggal_lahir)->format('d M Y') : '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Jenis Kelamin</span>
                        <span class="font-medium text-gray-800">{{ $b->jenis_kelamin ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Agama</span>
                        <span class="font-medium text-gray-800">{{ $b->agama ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Alamat</span>
                        <span class="font-medium text-gray-800 text-right">{{ $b->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- DATA AKADEMIK --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">
                    Informasi Akademik
                </h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Asal Sekolah / Univ</span>
                        <span class="font-medium text-gray-800">{{ $b->asal_sekolah ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Jurusan</span>
                        <span class="font-medium text-gray-800">{{ $b->jurusan ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">Semester</span>
                        <span class="font-medium text-gray-800">{{ $b->semester ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-500">IPK</span>
                        <span class="font-medium text-gray-800">{{ $b->ipk ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ================= UPDATE STATUS ================= --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="p-6">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Update Status Lamaran</h2>

                <span class="px-4 py-2 rounded-full text-sm font-semibold bg-{{ $pelamar->status_color }}-100 text-{{ $pelamar->status_color }}-800">
                    Status Saat Ini: {{ $pelamar->status_label }}
                </span>
            </div>

            <form action="{{ route('admin.pelamar.update-status', $pelamar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Status Lamaran</label>
                    <select id="status" name="status"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" {{ $pelamar->status=='pending'?'selected':'' }}>Menunggu</option>
                        <option value="diterima" {{ $pelamar->status=='diterima'?'selected':'' }}>Diterima</option>
                        <option value="ditolak" {{ $pelamar->status=='ditolak'?'selected':'' }}>Ditolak</option>
                        <option value="revisi" {{ $pelamar->status=='revisi'?'selected':'' }}>Revisi</option>
                        <option value="magang_berjalan" {{ $pelamar->status=='magang_berjalan'?'selected':'' }}>Magang Berjalan</option>
                        <option value="magang_selesai" {{ $pelamar->status=='magang_selesai'?'selected':'' }}>Magang Selesai</option>
                    </select>
                </div>

                <div id="suratDiterimaSection" class="hidden mb-4">
                    <label class="block text-sm font-medium mb-2">Upload Surat Diterima (PDF)</label>
                    <input type="file" name="surat_diterima" accept=".pdf" class="w-full">
                </div>

                <div id="suratDitolakSection" class="hidden mb-4">
                    <label class="block text-sm font-medium mb-2">Upload Surat Ditolak (PDF)</label>
                    <input type="file" name="surat_ditolak" accept=".pdf" class="w-full">
                </div>

                <div id="revisiSection" class="hidden mb-4">
                    <label class="block text-sm font-medium mb-2">Catatan Revisi</label>
                    <textarea name="catatan_revisi" class="w-full border rounded p-2"></textarea>
                </div>

                <!-- <div id="sertifikatSection" class="hidden mb-4">
                    <label class="block text-sm font-medium mb-2">Upload Sertifikat (PDF)</label>
                    <input type="file" name="sertifikat" accept=".pdf" class="w-full">
                </div> -->

                <div class="flex justify-end">
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Status
                    </button>
                </div>
            </form>

        </div>
    </div>


{{-- ================= POSISI SAAT INI ================= --}}
@if($pelamar->posisi)
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-6">
        <strong>Pelamar sudah ditempatkan di posisi:</strong>
        <span class="font-semibold">{{ $pelamar->posisi->nama_posisi }}</span>
    </div>
@endif


{{-- ================= PENEMPATAN POSISI ================= --}}
@if(in_array($pelamar->status, ['diterima','magang_berjalan','magang_selesai']))
<div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Penempatan Posisi Magang</h2>

        <form action="{{ route('admin.setPosisi', $pelamar->id) }}" method="POST">
            @csrf

            <label class="block text-sm font-semibold mb-2">Pilih Posisi</label>

            <select name="posisi_id"
                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 mb-4">

                <option value="">-- Pilih Posisi --</option>

                @foreach($posisis as $posisi)
                    @php
                       $terisi = $posisi->lamarans_count;
                       $sisa = $posisi->kuota - $terisi;

                        // Posisi penuh KECUALI jika itu posisi milik pelamar sekarang
                        $disable = ($sisa <= 0 && $pelamar->posisi_id != $posisi->id);
                    @endphp

                    <option value="{{ $posisi->id }}"
                        {{ $pelamar->posisi_id == $posisi->id ? 'selected' : '' }}
                        {{ $disable ? 'disabled' : '' }}>

                        {{ $posisi->nama_posisi }}
                        • Sisa Kuota: {{ $sisa }}
                        {{ $disable ? '(PENUH)' : '' }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Simpan Penempatan
            </button>
        </form>
    </div>
</div>
@endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const status = document.getElementById('status');

    function updateSection(val){
        document.getElementById('suratDiterimaSection').classList.add('hidden');
        document.getElementById('suratDitolakSection').classList.add('hidden');
        document.getElementById('revisiSection').classList.add('hidden');
        document.getElementById('sertifikatSection').classList.add('hidden');

        if(val==='diterima'){
            document.getElementById('suratDiterimaSection').classList.remove('hidden');
        }
        if(val==='ditolak'){
            document.getElementById('suratDitolakSection').classList.remove('hidden');
        }
        if(val==='revisi'){
            document.getElementById('revisiSection').classList.remove('hidden');
        }
        if(val==='magang_selesai'){
            document.getElementById('sertifikatSection').classList.remove('hidden');
        }
    }

    updateSection(status.value);
    status.addEventListener('change', e => updateSection(e.target.value));
});
</script>
@endpush
@endsection