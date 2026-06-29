@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Pengaturan Program Magang
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola status pembukaan dan penutupan program magang.
        </p>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl shadow-sm">
            <i class="fas fa-check-circle text-xl"></i>

            <span>
                {{ session('success') }}
            </span>
        </div>
    @endif

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

        {{-- TOP STATUS --}}
        <div class="px-6 py-5
            {{ $pengaturan && $pengaturan->magang_dibuka 
                ? 'bg-gradient-to-r from-green-500 to-emerald-500' 
                : 'bg-gradient-to-r from-red-500 to-pink-500' }}">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-white text-xl font-bold">
                        Status Program
                    </h2>

                    <p class="text-white/80 mt-1">
                        {{
                            $pengaturan && $pengaturan->magang_dibuka
                            ? 'Program magang sedang dibuka'
                            : 'Program magang sedang ditutup'
                        }}
                    </p>
                </div>

                <div class="text-5xl text-white">
                    @if($pengaturan && $pengaturan->magang_dibuka)
                        <i class="fas fa-lock-open"></i>
                    @else
                        <i class="fas fa-lock"></i>
                    @endif
                </div>

            </div>
        </div>

        {{-- FORM --}}
        <div class="p-6">

            <form action="{{ route('admin.pengaturan.update') }}"
                  method="POST">

                @csrf

                {{-- LABEL --}}
                <label class="block text-gray-700 font-semibold mb-3">
                    Status Program Magang
                </label>

                {{-- SELECT --}}
                <select name="magang_dibuka"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        required>

                    <option value="1"
                        {{ $pengaturan && $pengaturan->magang_dibuka ? 'selected' : '' }}>
                        🟢 Dibuka
                    </option>

                    <option value="0"
                        {{ $pengaturan && !$pengaturan->magang_dibuka ? 'selected' : '' }}>
                        🔴 Ditutup
                    </option>

                </select>

                {{-- INFO --}}
                <div class="mt-4 p-4 rounded-xl bg-blue-50 border border-blue-100 text-sm text-blue-700">

                    <div class="flex items-start gap-2">

                        <i class="fas fa-info-circle mt-0.5"></i>

                        <p>
                            Jika program ditutup, maka pelamar tidak dapat
                            melakukan pendaftaran maupun mengajukan lamaran.
                        </p>

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-6 flex justify-end">

                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg transition duration-200 font-semibold">

                        <i class="fas fa-save mr-2"></i>
                        Simpan Pengaturan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection