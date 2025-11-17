@extends('layouts.pelamar')

@section('title', 'Riwayat Lamaran Saya')

@section('content')
<h1 class="text-2xl font-bold mb-5">Riwayat Lamaran Saya</h1>

<div class="mb-5 flex flex-wrap gap-4">
    <form action="{{ route('pelamar.rekap') }}" method="GET" class="w-full">
        <div class="flex flex-wrap gap-4">
            <input type="text" name="search" placeholder="Cari riwayat..." 
                   value="{{ request('search') }}"
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md">
            
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-md">
                <option value="">Semua Status</option>
                @foreach(['diterima', 'ditolak', 'pending', 'magang_berjalan', 'magang_selesai'] as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </form>
</div>

<div class="bg-white p-5 shadow-md rounded-md overflow-x-auto">
    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-blue-600 text-white sticky top-0">
                <th class="border border-gray-300 px-4 py-2">No</th>
                <th class="border border-gray-300 px-4 py-2">Periode Magang</th>
                <th class="border border-gray-300 px-4 py-2">Status</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamarans as $lamaran)
            <tr>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    {{ $loop->iteration }}
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    {{ \Carbon\Carbon::parse($lamaran->tanggal_mulai)->format('d/m/Y') }} - 
                    {{ \Carbon\Carbon::parse($lamaran->tanggal_selesai)->format('d/m/Y') }}
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <span class="px-2 py-1 rounded-full text-sm 
                        @if($lamaran->status === 'diterima') bg-green-100 text-green-800
                        @elseif($lamaran->status === 'ditolak') bg-red-100 text-red-800
                        @elseif($lamaran->status === 'magang_berjalan') bg-blue-100 text-blue-800
                        @elseif($lamaran->status === 'magang_selesai') bg-gray-100 text-gray-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucwords(str_replace('_', ' ', $lamaran->status)) }}
                    </span>
                </td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    <button onclick="showDetail({{ $lamaran->id }})" 
                            class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        <i class="fas fa-eye"></i> Detail
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border border-gray-300 px-4 py-2 text-center">
                    Tidak ada riwayat lamaran.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $lamarans->links() }}
    </div>
</div>

@push('scripts')
<script>
    function showDetail(id) {
        window.location.href = `/pelamar/detail/${id}`;
    }
</script>
@endpush
@endsection
