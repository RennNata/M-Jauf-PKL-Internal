@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeIn">
                <div class="card-header border-0 py-4 text-center text-white" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-key-fill me-2"></i>Pulihkan Password</h4>
                </div>

                <div class="card-body p-5">
                    @if (session('status'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 animate__animated animate__tada" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-muted text-center mb-4 small">Jangan khawatir! Masukkan email Anda, kami akan kirimkan link ajaib untuk mengatur ulang password Anda.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">ALAMAT EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-success"></i></span>
                                <input type="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                            </div>
                            @error('email') <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                                Kirim Link Reset
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-muted small fw-bold mt-2">
                                <i class="bi bi-arrow-left"></i> Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection