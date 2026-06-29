@extends('layouts.admin')

@section('title', 'Data Alumni Magang')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Data Alumni Magang</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter -->
    <div class="flex justify-between mb-4">
        <select id="entries" class="border rounded p-2">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>

        <input type="text" id="search" placeholder="Cari..." 
               class="border p-2 rounded w-60">
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full border">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Asal</th>
                    <th class="p-2">Jurusan</th>
                    <th class="p-2">Periode</th>
                    <th class="p-2">Sertifikat</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($alumni as $index => $a)
                <tr class="border-t">
                    <td class="p-2">{{ $alumni->firstItem() + $index }}</td>

                    <td class="p-2">
                        <b>{{ $a->nama }}</b><br>
                        <small>{{ $a->email }}</small>
                    </td>

                    <td class="p-2">{{ $a->asal_sekolah }}</td>
                    <td class="p-2">{{ $a->jurusan }}</td>

                    <td class="p-2">
                        {{ \Carbon\Carbon::parse($a->tanggal_mulai)->format('d M Y') }} -
                        {{ \Carbon\Carbon::parse($a->tanggal_selesai)->format('d M Y') }}
                    </td>

                    <td class="p-2">
                        @if($a->sertifikat_path)
                            <!-- FIX DI SINI -->
                            <a href="{{ route('admin.alumni.download-sertifikat', $a->id) }}"
                               class="text-blue-600">
                               Download
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    <td class="p-2 flex gap-2">
                        <a href="{{ route('admin.detailalumni', $a->id) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded">
                           Detail
                        </a>

                        <form action="{{ route('admin.alumni.destroy', $a->id) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $alumni->links() }}
    </div>
</div>

@push('scripts')
<script>
document.getElementById('search').addEventListener('keyup', function() {
    let val = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
    });
});
</script>
@endpush

@endsection