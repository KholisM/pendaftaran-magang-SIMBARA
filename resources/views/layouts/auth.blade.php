<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Authentication Page')</title>

    <!-- Favicon -->
    <link href="{{ asset('assets/img/capil.png') }}" rel="icon">

    <!-- Bootstrap 5 (upgrade dari 4 biar modern & stabil) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            background: linear-gradient(135deg, #eef2f3, #dfe9f3);
            font-family: 'Segoe UI', sans-serif;
        }

        .logo {
            width: 90px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    {{-- LOGO ATAS --}}
    <div class="text-center mt-4">
        <img src="{{ asset('assets/img/capil.png') }}" class="logo">
    </div>

    {{-- CONTENT --}}
    @yield('content')

</body>
</html>