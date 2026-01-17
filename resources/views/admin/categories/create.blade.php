@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-folder-plus text-success me-2"></i>Buat Kategori Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Tanaman Hias Gantung">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Penjelasan singkat kategori...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Gambar Kategori</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        <small class="text-muted">Gunakan gambar yang mewakili kategori ini (Maks. 2MB)</small>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="isActive">
                        <label class="form-check-label fw-bold" for="isActive">Aktifkan Kategori</label>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-5 text-white fw-bold">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection