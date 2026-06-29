@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="bg-white shadow-md rounded p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Edit Posisi</h1>

            <a href="{{ route('admin.posisi') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ← Kembali
            </a>
        </div>

        <form action="{{ route('admin.posisi.update', $posisi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-2 font-medium">Nama Posisi</label>
                <input type="text" name="nama_posisi"
                       value="{{ $posisi->nama_posisi }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Kuota</label>
                <input type="number" name="kuota"
                       value="{{ $posisi->kuota }}"
                       class="w-full border rounded px-3 py-2"
                       required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-medium">Deskripsi</label>
                <textarea name="deskripsi"
                          class="w-full border rounded px-3 py-2"
                          rows="3">{{ $posisi->deskripsi }}</textarea>
            </div>

            <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Update Posisi
            </button>
        </form>

    </div>
</div>
@endsection