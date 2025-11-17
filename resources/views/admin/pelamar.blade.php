@extends('layouts.admin')

@section('title', 'Data Pelamar Magang')
@section('page_title', 'Data Pelamar Magang')

@section('content')
<div class="space-y-6">
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Data Pelamar</h1>
        
        <!-- Filter & Search Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex items-center space-x-4">
                <label class="text-sm text-gray-700">Show 
                    <select id="entries" class="border rounded p-2 focus:ring-2 focus:ring-blue-500">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select> entries
                </label>
            </div>
            <div class="relative w-full md:w-64 mt-4 md:mt-0">
                <input type="text" id="search" class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                       placeholder="Cari pelamar..." value="{{ request('search') }}">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full border rounded-lg overflow-hidden" id="pelamarTable">
                <thead class="bg-blue-600 text-white sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Asal Universitas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Jurusan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pelamars as $index => $pelamar)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $pelamars->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $pelamar->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $pelamar->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pelamar->asal_sekolah }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pelamar->jurusan }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($pelamar->tanggal_mulai)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-{{ $pelamar->status_color }}-200 text-{{ $pelamar->status_color }}-800">
                                {{ $pelamar->status_label }}
                            </span>
                        </td>                        
                        <td class="px-6 py-4 text-center text-sm font-medium">
                            <a href="{{ route('admin.detail.pelamar', $pelamar->id) }}" 
                               class="bg-blue-500 text-white px-3 py-1 rounded-md text-sm font-medium hover:bg-blue-600 transition flex items-center justify-center">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data pelamar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Showing {{ $pelamars->firstItem() ?? 0 }} to {{ $pelamars->lastItem() ?? 0 }} of {{ $pelamars->total() ?? 0 }} entries
            </div>
            {{ $pelamars->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const entriesSelect = document.getElementById('entries');
    let searchTimeout;

    // Handle search with debouncing
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateQueryString();
        }, 500);
    });
    
    // Handle entries change
    entriesSelect.addEventListener('change', function() {
        updateQueryString();
    });

    function updateQueryString() {
        const searchTerm = searchInput.value;
        const entriesValue = entriesSelect.value;
        
        const params = new URLSearchParams(window.location.search);
        
        if (searchTerm) {
            params.set('search', searchTerm);
        } else {
            params.delete('search');
        }
        
        params.set('per_page', entriesValue);
        
        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }
});
</script>
@endpush
@endsection