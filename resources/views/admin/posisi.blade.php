@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Posisi Magang</h1>
            <p class="text-sm text-gray-500">Kelola posisi dan kuota magang</p>
        </div>

        <a href="{{ route('admin.posisi.create') }}" 
           class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-2 rounded-lg shadow hover:scale-105 transition">
            <i class="fas fa-plus mr-2"></i> Tambah Posisi
        </a>
    </div>

    <!-- TABLE CARD -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-left">Posisi</th>
                        <th class="px-6 py-4 text-left">Kuota</th>
                        <th class="px-6 py-4 text-left">Terisi</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">

                @foreach($posisis as $posisi)
                @php
                    $terisi = $posisi->lamarans->count();
                    $kuota = $posisi->kuota;
                    $persen = $kuota > 0 ? ($terisi / $kuota) * 100 : 0;
                @endphp

                <tr class="hover:bg-gray-50 transition">

                    <!-- NAMA POSISI -->
                    <td class="px-6 py-4 font-semibold text-gray-800">
                        {{ $posisi->nama_posisi }}
                    </td>

                    <!-- KUOTA -->
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                            {{ $kuota }}
                        </span>
                    </td>

                    <!-- TERISI + PROGRESS -->
                    <td class="px-6 py-4 w-64">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>{{ $terisi }} orang</span>
                            <span>{{ round($persen) }}%</span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full 
                                {{ $persen >= 100 ? 'bg-red-500' : ($persen > 60 ? 'bg-yellow-400' : 'bg-green-500') }}"
                                style="width: {{ $persen }}%">
                            </div>
                        </div>
                    </td>

                    <!-- AKSI -->
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('admin.posisi.edit',$posisi->id) }}" 
                               class="px-3 py-1 bg-yellow-400 text-white rounded-md hover:bg-yellow-500 transition text-xs">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.posisi.delete',$posisi->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus posisi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition text-xs">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection