@extends('layouts.app')

@section('content')
{{-- Library animasi --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden animate__animated animate__zoomIn">
                
                {{-- Progress Bar Tipis di Atas Card --}}
                <div class="progress" style="height: 5px; border-radius: 0;">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 75%"></div>
                </div>

                <div class="card-body p-5 text-center">
                    {{-- Icon Animasi --}}
                    <div class="mb-4 d-inline-block p-4 rounded-circle bg-success-subtle animate__animated animate__pulse animate__infinite">
                        <img src="https://www.svgrepo.com/show/491512/email-open.svg" width="80" alt="Email icon">
                    </div>

                    <h3 class="fw-bold text-dark mb-3">Verifikasi Email Anda</h3>
                    
                    <p class="text-muted mb-4">
                        Satu langkah lagi! Kami telah mengirimkan link verifikasi ke email Anda. 
                        Silakan klik link tersebut untuk mengaktifkan akun.
                    </p>

                    {{-- Info Alert jika Link Berhasil Dikirim Ulang --}}
                    @if (session('resent'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 py-3 mb-4 animate__animated animate__headShake" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Link verifikasi baru telah dikirim ke email Anda!
                        </div>
                    @endif

                    <div class="bg-light p-4 rounded-4 mb-4">
                        <p class="small text-muted mb-0">
                            <i class="bi bi-info-circle me-1"></i> 
                            Tidak menemukan email? Cek folder <strong>Spam</strong> atau klik tombol di bawah untuk mengirim ulang.
                        </p>
                    </div>

                    <form class="d-grid gap-2" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm py-3 transition-all">
                            <i class="bi bi-envelope-paper-fill me-2"></i> Kirim Ulang Email
                        </button>
                    </form>

                    <div class="mt-4">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-decoration-none text-muted small fw-bold hover-danger">
                           <i class="bi bi-box-arrow-left me-1"></i> Keluar / Batalkan
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-subtle { background-color: #e1f2e9; }
    .transition-all { transition: all 0.3s ease; }
    .btn-success:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3) !important; }
    .hover-danger:hover { color: #dc3545 !important; }
</style>
@endsection