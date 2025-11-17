@extends('layouts.admin')

@section('title', 'Data Alumni Magang')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Data Alumni Magang</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 relative">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="flex items-center space-x-4">
            <label class="text-sm text-gray-700">Show 
                <select id="entries" class="border rounded p-2 focus:ring-2 focus:ring-blue-500">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select> entries
            </label>
        </div>
        <div class="relative w-full md:w-64">
            <input type="text" id="search" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Cari alumni...">
            <div class="absolute left-3 top-2.5 text-gray-400">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <!-- Alumni List -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="bg-blue-600 text-white sticky top-0">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama / Email</th>
                        <th class="px-6 py-3">Asal Universitas</th>
                        <th class="px-6 py-3">Jurusan</th>
                        <th class="px-6 py-3">Periode Magang</th>
                        <th class="px-6 py-3">Sertifikat</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($alumni as $index => $alumnus)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $alumni->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $alumnus->nama }}</div>
                            <div class="text-gray-500">{{ $alumnus->email }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $alumnus->asal_sekolah }}</td>
                        <td class="px-6 py-4">{{ $alumnus->jurusan }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($alumnus->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($alumnus->tanggal_selesai)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($alumnus->sertifikat_path)
                            <a href="{{ route('admin.alumni.download-sertifikat', $alumnus->id) }}>" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-file-pdf mr-2"></i> Download
                            </a>
                            @else
                            <span class="text-gray-500">Tidak tersedia</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.detailalumni', $alumnus->id) }}" class="text-white bg-blue-600 hover:bg-blue-500 px-3 py-1 rounded">
                                <i class="fas fa-eye mr-2"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 flex justify-between items-center">
            <span class="text-sm text-gray-700">Showing {{ $alumni->firstItem() ?? 0 }} to {{ $alumni->lastItem() ?? 0 }} of {{ $alumni->total() ?? 0 }} entries</span>
            {{ $alumni->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const entriesSelect = document.getElementById('entries');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(searchTerm) ? '' : 'none';
        });
    });
    
    entriesSelect.addEventListener('change', function() {
        window.location.href = `${window.location.pathname}?per_page=${this.value}`;
    });
});
</script>
@endpush
@endsection