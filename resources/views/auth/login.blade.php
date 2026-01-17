@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeIn">
                {{-- Header dengan Gradasi Hijau --}}
                <div class="card-header border-0 py-4 text-center" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                    <h3 class="mb-0 text-white fw-bold">Selamat Datang!</h3>
                    <p class="text-white-50 small mb-0">Masuk untuk melanjutkan belanja tanaman</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-muted small">ALAMAT EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-success"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-bold text-muted small">KATA SANDI</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small fw-bold text-success" href="{{ route('password.request') }}">Lupa?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-success"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">Ingat saya di perangkat ini</label>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                                Masuk Sekarang
                            </button>
                        </div>

                        <div class="position-relative mb-4">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau masuk dengan</span>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-dark rounded-pill d-flex align-items-center justify-content-center fw-bold border-1">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2">
                                Google Akun
                            </a>
                        </div>

                        <p class="text-center mb-0 small text-muted">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-success fw-bold text-decoration-none">Daftar Sekarang</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection