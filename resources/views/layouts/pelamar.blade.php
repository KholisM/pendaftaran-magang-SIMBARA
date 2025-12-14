<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pelamar')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Favicons -->
    <link href="{{ asset('assets/img/logojabar.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
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
    @stack('styles') 
</head>
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-md px-6 py-3 flex items-center justify-between z-50">
        <!-- Logo & Title -->
        <div class="flex items-center space-x-3">
            <img src="{{ asset('assets/img/logojabar.png') }}" alt="Logo" class="h-10 w-10 object-contain">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Dinas Sosial</h1>
                <p class="text-sm text-gray-700">Kota Bogor</p>
            </div>
        </div>        
        
        <!-- User Profile -->
        <div class="flex items-center space-x-4">
            @if(Auth::user()->biodata && Auth::user()->biodata->profile_photo && Storage::disk('public')->exists(Auth::user()->biodata->profile_photo))
                <img src="{{ asset('storage/' . Auth::user()->biodata->profile_photo) }}" 
                    alt="Foto Profil" 
                    class="h-10 w-10 rounded-full object-cover border-2 border-gray-300 shadow-md">
            @else
                <img src="{{ asset('images/default-profile.png') }}" 
                    alt="Default Profile" 
                    class="h-10 w-10 rounded-full object-cover border-2 border-gray-300 shadow-md">
            @endif
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
            @include('layouts.sidebar-pelamar')
            <div class="flex-1 p-10 ml-64">
                @yield('content')
            </div>
        </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
</body>
</html>