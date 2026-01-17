@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeInUp">
                <div class="card-header border-0 py-4 text-center text-white" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                    <h3 class="mb-0 fw-bold">Buat Akun Baru</h3>
                    <p class="text-white-50 small mb-0">Gabung dengan komunitas pecinta tanaman kami</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label fw-bold text-muted small">NAMA LENGKAP</label>
                                <input id="name" type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso">
                                @error('name') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label fw-bold text-muted small">ALAMAT EMAIL</label>
                                <input id="email" type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="email@anda.com">
                                @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold text-muted small">KATA SANDI</label>
                                <input id="password" type="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                                @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="password-confirm" class="form-label fw-bold text-muted small">KONFIRMASI SANDI</label>
                                <input id="password-confirm" type="password" class="form-control form-control-lg bg-light border-0" name="password_confirmation" required placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                                Daftar Akun
                            </button>
                        </div>

                        <div class="position-relative mb-4 text-center">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau daftar dengan</span>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-dark rounded-pill d-flex align-items-center justify-content-center fw-bold border-1">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2">
                                Daftar via Google
                            </a>
                        </div>

                        <p class="text-center mb-0 small text-muted">
                            Sudah punya akun? <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">Masuk di sini</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection