@extends('layouts.auth')

@section('content')

<style>
/* BACKGROUND */
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
}

/* CONTAINER */
.auth-container {
    min-height: 100vh;
}

/* CARD GLASS */
.auth-card {
    backdrop-filter: blur(15px);
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    overflow: hidden;
    max-width: 900px;
    width: 100%;
}

/* LEFT SIDE */
.auth-left {
    color: white;
    padding: 50px;
}

.auth-left h2 {
    font-weight: bold;
}

.auth-left p {
    opacity: 0.9;
}

/* RIGHT SIDE */
.auth-right {
    background: white;
    padding: 50px;
    border-radius: 20px 0 0 20px;
}

/* INPUT */
.form-control {
    border-radius: 12px;
    padding: 12px;
}

/* BUTTON */
.btn-login {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 12px;
    padding: 10px;
    transition: 0.3s;
}

.btn-login:hover {
    opacity: 0.9;
}

/* LINK */
.auth-link {
    color: #667eea;
    font-weight: 500;
}

/* RESPONSIVE */
@media(max-width:768px){
    .auth-left {
        display: none;
    }
    .auth-right {
        border-radius: 20px;
    }
}
</style>

<div class="container auth-container d-flex justify-content-center align-items-center">

    <div class="auth-card row">

        {{-- LEFT --}}
        <div class="col-md-6 auth-left d-flex flex-column justify-content-center">
            <h2>Magang Lebih Mudah 🚀</h2>
            <p>Daftar, pantau, dan kelola proses magang kamu dalam satu sistem terintegrasi.</p>
        </div>

        {{-- RIGHT --}}
        <div class="col-md-6 auth-right">

            <h4 class="mb-4 text-center">Login Akun</h4>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required>

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="checkbox" name="remember"> Remember Me
                </div>

                <button type="submit" class="btn btn-login w-100 text-white">
                    Login
                </button>

                <div class="text-center mt-4">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
                </div>

            </form>
        </div>

    </div>

</div>

@endsection