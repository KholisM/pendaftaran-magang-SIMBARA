    <div class="w-64 bg-white shadow-md p-5">
        <div class="text-center mb-5">
            <h2 class="mt-3 text-lg font-semibold">{{ Auth::user()->name }}</h2>
            <p class="text-sm text-gray-500">Administrator</p>
        </div>
        <nav>
            <ul>
                <li class="mb-2">
                    <a href="{{ route('admin.dashboard') }}" 
                    class="flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i> Beranda
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.pelamar') }}" 
                    class="flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.pelamar*') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                        <i class="fas fa-users mr-2"></i> Data Pelamar
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('admin.alumni') }}" 
                    class="flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.pelamar*') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                        <i class="fas fa-users mr-2"></i> Alumni
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-2 rounded-md bg-red-500 text-white text-center hover:bg-red-600 w-full">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>