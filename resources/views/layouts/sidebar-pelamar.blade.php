@inject('lamaranService', 'App\Services\LamaranService')

<div class="w-64 bg-white shadow-md p-5 fixed-sidebar">
    <div class="text-center mb-5">
        @if(Auth::user()->biodata && Auth::user()->biodata->profile_photo && Storage::disk('public')->exists(Auth::user()->biodata->profile_photo))
            <img src="{{ asset('storage/' . Auth::user()->biodata->profile_photo) }}" 
                 alt="Foto Profil" 
                 class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-gray-300 shadow-lg">
        @else
            <img src="{{ asset('images/default-profile.png') }}" 
                 alt="Default Profile Photo" 
                 class="w-24 h-24 rounded-full mx-auto object-cover border-2 border-gray-300 shadow-lg">
        @endif
    
        <h2 class="mt-3 text-lg font-semibold">{{ Auth::user()->name }}</h2>
    </div>
    
    <nav>
        <ul>
            <li class="mb-2">
                <a href="{{ route('pelamar.status') }}" 
                   class="block px-4 py-2 rounded-md {{ request()->routeIs('pelamar.status') ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-home mr-2"></i>
                    Beranda
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('pelamar.biodata') }}" 
                   class="block px-4 py-2 rounded-md {{ request()->routeIs('pelamar.biodata') ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-user mr-2"></i>
                    Biodata
                </a>
            </li>

            {{-- Cek status lamaran untuk menampilkan menu formulir --}}
            @if(!$lamaranService->hasActiveLamaran(Auth::id()))
            <li class="mb-2">
                <a href="{{ route('pelamar.formulir') }}" 
                   class="block px-4 py-2 rounded-md {{ request()->routeIs('pelamar.formulir') ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-file-alt mr-2"></i>
                    Formulir Lamaran
                </a>
            </li>
            @endif

            <li class="mb-2">
                <a href="{{ route('pelamar.rekap') }}" 
                   class="block px-4 py-2 rounded-md {{ request()->routeIs('pelamar.rekap') ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                    <i class="fas fa-history mr-2"></i>
                    Riwayat Magang
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 rounded-md bg-red-500 text-white text-center hover:bg-red-600">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>