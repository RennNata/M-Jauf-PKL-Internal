{{-- resources/views/profile/partials/update-password-form.blade.php --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1"><i class="bi bi-shield-lock me-2 text-success"></i>Keamanan Akun</h5>
        <p class="text-muted small mb-4">Gunakan password yang kuat agar akunmu tetap terjaga.</p>

        <form method="post" action="{{ route('profile.password.update') }}">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="current_password" class="form-label fw-semibold small text-muted">Password Saat Ini</label>
                <input type="password" name="current_password" id="current_password" class="form-control rounded-pill px-3 @error('current_password', 'updatePassword') is-invalid @enderror">
                @error('current_password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold small text-muted">Password Baru</label>
                <input type="password" name="password" id="password" class="form-control rounded-pill px-3 @error('password', 'updatePassword') is-invalid @enderror">
                @error('password', 'updatePassword') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold small text-muted">Ulangi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control rounded-pill px-3">
            </div>

            <button type="submit" class="btn btn-dark px-4 rounded-pill fw-bold shadow-sm">
                Perbarui Password
            </button>
        </form>
    </div>
</div>