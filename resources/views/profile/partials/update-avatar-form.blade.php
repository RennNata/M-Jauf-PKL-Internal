{{-- resources/views/profile/partials/update-avatar-form.blade.php --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-1"><i class="bi bi-camera me-2 text-success"></i>Foto Profil</h5>
        <p class="text-muted small mb-4">Format: JPG, PNG, WebP (Maksimal 2MB).</p>

        <form method="post" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="d-flex align-items-center gap-4 flex-wrap">
                {{-- Avatar Display --}}
                <div class="position-relative">
                    <div class="rounded-circle border border-4 border-white shadow-sm overflow-hidden" style="width: 120px; height: 120px;">
                        <img id="avatar-preview" class="w-100 h-100 object-fit-cover"
                             src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                    </div>
                    @if($user->avatar)
                        <button type="button" onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()"
                                class="btn btn-danger btn-sm rounded-circle position-absolute bottom-0 end-0 border-white border-2 p-1"
                                style="width: 32px; height: 32px;" title="Hapus foto">
                            <i class="bi bi-trash-fill small"></i>
                        </button>
                    @endif
                </div>

                {{-- Upload Input --}}
                <div class="flex-grow-1">
                    <label class="form-label fw-semibold small text-muted">Ganti Foto Baru</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(event)"
                           class="form-control rounded-pill @error('avatar') is-invalid @enderror">
                    @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    
                    <button type="submit" class="btn btn-outline-success mt-3 px-4 rounded-pill fw-bold btn-sm">
                        Unggah Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" class="d-none">
    @csrf @method('DELETE')
</form>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('avatar-preview').src = e.target.result;
            reader.readAsDataURL(file);
        }
    }
</script>