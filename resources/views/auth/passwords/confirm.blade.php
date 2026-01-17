@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__shakeX">
                <div class="card-header border-0 py-4 text-center text-white" style="background: #212529;">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2"></i>Konfirmasi Keamanan</h4>
                </div>

                <div class="card-body p-5">
                    <p class="text-muted text-center mb-4">Demi keamanan, silakan masukkan password Anda kembali sebelum melanjutkan.</p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">PASSWORD</label>
                            <input id="password" type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" name="password" required autofocus>
                            @error('password') <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill fw-bold shadow-sm">
                                Konfirmasi
                            </button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-decoration-none text-success small fw-bold" href="{{ route('password.request') }}">
                                    Lupa Password Anda?
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 