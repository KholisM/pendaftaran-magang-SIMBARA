@extends('layouts.pelamar')

@section('title', 'Biodata Pelamar')
@php
    $pengaturan = \App\Models\Pengaturan::first();
@endphp
@section('content')

<style>
.glass {
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.8);
}
.card-hover:hover {
    transform: translateY(-5px);
}
</style>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-purple-600 via-blue-500 to-indigo-600 text-white p-8 rounded-2xl shadow-xl">
        <h1 class="text-3xl font-bold">Profil Kamu ✨</h1>
        <p class="opacity-90 mt-2">Lengkapi data untuk meningkatkan peluang diterima magang</p>
    </div>

    {{-- BUTTON --}}
    <div class="flex gap-3">
        <a href="{{ route('pelamar.edit-biodata') }}"
           class="px-5 py-2 bg-indigo-600 text-white rounded-xl shadow hover:bg-indigo-700 transition">
            ✏️ Edit Profil
        </a>

        @php
    $pengaturan = \App\Models\Pengaturan::first();
@endphp

@if($pengaturan && $pengaturan->magang_dibuka)

    <a href="{{ route('pelamar.formulir') }}"
       class="px-5 py-2 bg-green-500 text-white rounded-xl shadow hover:bg-green-600 transition">

        🚀 Lanjut Daftar

    </a>

@else

    <button
        class="px-5 py-2 bg-gray-400 text-white rounded-xl shadow cursor-not-allowed"
        disabled>

        🔒 Pendaftaran Ditutup

    </button>

@endif
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- PROFILE --}}
        <div class="glass rounded-2xl shadow-xl p-6 text-center card-hover transition">

            @if($user->biodata && $user->biodata->profile_photo)
                <img src="{{ asset('storage/' . $user->biodata->profile_photo) }}"
                     class="w-36 h-36 mx-auto rounded-full object-cover border-4 border-white shadow-lg">
            @else
                <div class="w-36 h-36 mx-auto rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white text-4xl shadow-lg">
                    {{ strtoupper(substr($user->name,0,1)) }}
                </div>
            @endif

            <h2 class="mt-4 text-xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-500">{{ $user->email }}</p>

            <div class="mt-4 space-y-2 text-sm text-gray-600">
                <p>🎓 {{ $user->biodata->asal_sekolah ?? '-' }}</p>
                <p>📚 {{ $user->biodata->jurusan ?? '-' }}</p>
            </div>
        </div>

        {{-- DETAIL --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- AKADEMIK --}}
            <div class="glass rounded-2xl shadow-xl p-6 card-hover transition">
                <h3 class="font-semibold mb-4 text-lg">📊 Informasi Akademik</h3>

                <div class="grid md:grid-cols-2 gap-4">

                    <div class="p-4 rounded-xl bg-gradient-to-r from-blue-100 to-blue-50">
                        <p class="text-sm text-gray-500">IPK</p>
                        <p class="text-2xl font-bold text-blue-600">
                            {{ $user->biodata->ipk ?? '-' }}
                        </p>
                    </div>

                    <div class="p-4 rounded-xl bg-gradient-to-r from-green-100 to-green-50">
                        <p class="text-sm text-gray-500">Semester</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $user->biodata->semester ?? '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- PERSONAL --}}
            <div class="glass rounded-2xl shadow-xl p-6 card-hover transition">
                <h3 class="font-semibold mb-4 text-lg">👤 Informasi Pribadi</h3>

                <div class="grid md:grid-cols-2 gap-4">

                    <div class="p-4 rounded-xl bg-gray-50">
                        <p class="text-sm text-gray-500">TTL</p>
                        <p class="font-semibold">
                            @if($user->biodata && $user->biodata->tanggal_lahir)
                                {{ $user->biodata->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($user->biodata->tanggal_lahir)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50">
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-semibold">{{ $user->biodata->jenis_kelamin ?? '-' }}</p>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50">
                        <p class="text-sm text-gray-500">Agama</p>
                        <p class="font-semibold">{{ $user->biodata->agama ?? '-' }}</p>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50">
                        <p class="text-sm text-gray-500">Alamat</p>
                        <p class="font-semibold">{{ $user->biodata->alamat ?? '-' }}</p>
                    </div>

                </div>
            </div>

            {{-- PROGRESS --}}
            <div class="glass rounded-2xl shadow-xl p-6 card-hover transition">

                <h3 class="font-semibold mb-4 text-lg">🚀 Progress Profil</h3>

                @php
                    $fields = ['name','email','asal_sekolah','jurusan','semester','jenis_kelamin','ipk'];
                    $filled = collect($fields)->filter(function($field) use ($user) {
                        return $field === 'name' || $field === 'email'
                            ? !empty($user->$field)
                            : !empty($user->biodata->$field ?? '');
                    })->count();
                    $percentage = round(($filled / count($fields)) * 100);
                @endphp

                <div class="mb-3 flex justify-between">
                    <span class="text-sm">Kelengkapan</span>
                    <span class="font-bold text-indigo-600">{{ $percentage }}%</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-blue-500 h-4 rounded-full transition-all duration-700"
                         style="width: {{ $percentage }}%">
                    </div>
                </div>

                <p class="mt-3 text-sm text-gray-600">
                    {{ $percentage < 100 ? 'Lengkapi profilmu biar peluang diterima makin besar 🚀' : 'Profil kamu sudah lengkap 🎉' }}
                </p>

            </div>

        </div>

    </div>
</div>

@endsection