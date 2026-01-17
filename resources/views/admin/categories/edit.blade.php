@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-success"><i class="bi bi-pencil-square me-2"></i>Edit Kategori</h5>
                <span class="badge bg-light text-muted">ID: #{{ $category->id }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-4 text-center">
                        <label class="form-label d-block fw-bold text-start">Gambar Saat Ini</label>
                        <img src="{{ $category->image ? asset('storage/'.$category->image) : 'https://via.placeholder.com/150' }}" 
                             class="rounded shadow-sm mb-3 border" width="300" style="object-fit: cover;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} id="isActive">
                        <label class="form-check-label fw-bold" for="isActive">Status Aktif</label>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light px-4">Kembali</a>
                        <button type="submit" class="btn btn-success px-5 fw-bold text-white">Update Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection