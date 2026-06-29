@extends('layouts.auth')

@section('content')

<style>
/* BACKGROUND sama seperti login */
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    min-height: 100vh;
}

/* CONTAINER */
.auth-container {
    min-height: 100vh;
}

/* CARD */
.auth-card {
    backdrop-filter: blur(15px);
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    overflow: hidden;
    max-width: 1000px;
    width: 100%;
}

/* LEFT */
.auth-left {
    color: white;
    padding: 50px;
}

.auth-left h2 {
    font-weight: bold;
}

/* RIGHT */
.auth-right {
    background: white;
    padding: 40px;
    border-radius: 20px 0 0 20px;
}

/* INPUT */
.form-control {
    border-radius: 12px;
    padding: 12px;
}

/* BUTTON */
.btn-register {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    border-radius: 12px;
    padding: 10px;
    transition: 0.3s;
}

.btn-register:hover {
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
            <h2>Buat Akun Baru ✨</h2>
            <p>Mulai perjalanan magangmu sekarang dan dapatkan pengalaman terbaik.</p>
        </div>

        {{-- RIGHT --}}
        <div class="col-md-6 auth-right">

            <h4 class="mb-4 text-center">Register</h4>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror" required>

                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="checkbox" name="agree" required>
                    <small>Saya menyatakan data yang diberikan benar</small>
                </div>

                <button type="submit" class="btn btn-register w-100 text-white">
                    Register
                </button>

                <div class="text-center mt-4">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="auth-link">Login</a>
                </div>

            </form>
        </div>

    </div>

</div>

@endsection