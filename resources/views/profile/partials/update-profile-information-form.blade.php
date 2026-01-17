{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1"><i class="bi bi-person-lines-fill me-2 text-success"></i>Informasi Profil</h5>
        <p class="text-muted small mb-4">Perbarui informasi profil dan alamat email kamu secara berkala.</p>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row g-3">
                {{-- Nama --}}
                <div class="col-md-6 mb-2">
                    <label for="name" class="form-label fw-semibold small text-muted">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control rounded-pill px-3 @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" required autofocus>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-2">
                    <label for="email" class="form-label fw-semibold small text-muted">Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-pill px-3 @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Phone --}}
                <div class="col-md-12 mb-2">
                    <label for="phone" class="form-label fw-semibold small text-muted">Nomor Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text rounded-start-pill bg-light border-end-0 text-muted">+62</span>
                        <input type="tel" name="phone" id="phone" class="form-control rounded-end-pill px-3 @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}" placeholder="8xxxxxxxxxx">
                    </div>
                    @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                {{-- Address --}}
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label fw-semibold small text-muted">Alamat Lengkap</label>
                    <textarea name="address" id="address" rows="3" class="form-control rounded-4 px-3 @error('address') is-invalid @enderror"
                              placeholder="Alamat lengkap untuk pengiriman">{{ old('address', $user->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-3">
                <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
                    Simpan Perubahan
                </button>
                @if (session('status') === 'profile-updated')
                    <span class="text-success small fw-medium animate__animated animate__fadeIn">Berhasil disimpan!</span>
                @endif
            </div>
        </form>
    </div>
</div>