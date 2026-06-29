@extends('layouts.pelamar')

@section('title', 'Riwayat Lamaran Saya')

@section('content')

<div class="space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Magang</h1>
        <p class="text-gray-500 text-sm">Lihat semua riwayat lamaran magang Anda</p>
    </div>

    <!-- FILTER -->
    <div class="bg-white p-5 rounded-xl shadow-sm">
        <form action="{{ route('pelamar.rekap') }}" method="GET">
            <div class="flex flex-col md:flex-row gap-4">
                
                <input type="text" name="search" 
                    placeholder="Cari posisi / periode..."
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">

                <select name="status" 
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    <option value="">Semua Status</option>
                    @foreach(['diterima', 'ditolak', 'pending', 'magang_berjalan', 'magang_selesai'] as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" 
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>

            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Periode</th>
                        <th class="px-4 py-3 text-left">Posisi</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y">
                    @forelse($lamarans as $lamaran)
                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($lamaran->tanggal_mulai)->format('d M Y') }}
                            <br>
                            <span class="text-gray-400 text-xs">
                                sampai {{ \Carbon\Carbon::parse($lamaran->tanggal_selesai)->format('d M Y') }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            @if($lamaran->posisi)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                    {{ $lamaran->posisi->nama_posisi }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">Belum ditempatkan</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($lamaran->status === 'diterima') bg-green-100 text-green-700
                                @elseif($lamaran->status === 'ditolak') bg-red-100 text-red-700
                                @elseif($lamaran->status === 'magang_berjalan') bg-blue-100 text-blue-700
                                @elseif($lamaran->status === 'magang_selesai') bg-gray-200 text-gray-700
                                @else bg-yellow-100 text-yellow-700
                                @endif">
                                {{ ucwords(str_replace('_', ' ', $lamaran->status)) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <button onclick="showDetail({{ $lamaran->id }})"
                                class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400">
                            Tidak ada riwayat lamaran 😢
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <div class="p-4">
            {{ $lamarans->links() }}
        </div>
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