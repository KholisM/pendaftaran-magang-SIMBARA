<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="{{ asset('assets/img/logojabar.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .card-hover:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #ffffff 0%, #2575fc 100%);
        }
        .fixed-sidebar {
            position: fixed;
            top: 64px; /* Sesuaikan dengan tinggi navbar */
            left: 0;
            height: calc(100% - 64px); /* Agar tidak tertutup navbar */
            overflow-y: auto;
            width: 16rem; /* Sesuaikan dengan lebar sidebar */
            background-color: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<nav class="fixed top-0 left-0 right-0 bg-white shadow-md px-6 py-3 flex items-center justify-between z-50">
    <!-- Logo & Title -->
    <div class="flex items-center space-x-3">
        <img src="{{ asset('assets/img/logojabar.png') }}" alt="Logo" class="h-10 w-10 object-contain">
        <div>
            <h1 class="text-lg font-semibold text-gray-900">Dinas Komunikasi dan Informatika</h1>
            <p class="text-sm text-gray-700">Kab. Indragiri Hulu</p>
        </div>
    </div>        
    
</nav>

<!-- Adjust main content padding to avoid being overlapped by navbar -->
<style>
    body {
        padding-top: 64px; /* Menghindari navbar menutupi konten */
    }
</style>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <div class="w-64 bg-white shadow-md p-5 fixed-sidebar">
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
                        class="flex items-center px-4 py-2 rounded-md {{ request()->routeIs('admin.alumni*') ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
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
        <div class="flex-1 p-10 ml-64">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataPelamar').DataTable();
        });
    </script>
    @stack('scripts')
</body>
</html>