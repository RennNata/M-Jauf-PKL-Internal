@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__fadeInUp">
                <div class="card-header border-0 py-4 text-center text-white" style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                    <h4 class="mb-0 fw-bold">Setel Ulang Password</h4>
                    <p class="text-white-50 small mb-0">Silakan buat password baru yang kuat</p>
                </div>

                <div class="card-body p-5">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">EMAIL ANDA</label>
                            <input type="email" class="form-control bg-light border-0 @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required readonly>
                            @error('email') <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">PASSWORD BARU</label>
                            <input id="password" type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" name="password" required placeholder="Minimal 8 karakter" autofocus>
                            @error('password') <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">ULANGI PASSWORD</label>
                            <input id="password-confirm" type="password" class="form-control bg-light border-0" name="password_confirmation" required placeholder="Konfirmasi password baru">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm">
                                Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection