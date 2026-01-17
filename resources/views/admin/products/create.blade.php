@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle text-success me-2"></i>Tambah Produk Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Monstera Adansonii">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Berat (gram)</label>
                            <input type="number" name="weight" class="form-control" value="{{ old('weight') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Jelaskan detail tanaman...">{{ old('description') }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-danger">HARGA DISKON (Rp) - Opsional</label>
                            <input type="number" name="discount_price" class="form-control" value="{{ old('discount_price') }}" placeholder="Kosongkan jika tidak ada diskon">
                            <small class="text-muted italic">Isi jika ingin menampilkan harga diskon.</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Stok</label>
                        <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Gambar Produk</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="isActive">
                        <label class="form-check-label fw-bold" for="isActive">Aktifkan Produk</label>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-success px-5">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection