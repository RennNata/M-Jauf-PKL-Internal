@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square text-success me-2"></i>Edit Produk</h5>
                <span class="badge bg-light text-muted">ID: #{{ $product->id }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-3 text-center">
                        <label class="form-label d-block fw-bold text-start">Gambar Saat Ini</label>
                        <img src="{{ asset('storage/' . ($product->primaryImage->image_path ?? 'products/default.png')) }}" 
                             class="rounded shadow-sm mb-3 border" width="300">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Produk</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category_id" class="form-select">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Berat (gram)</label>
                            <input type="number" name="weight" class="form-control" value="{{ $product->weight }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-danger">HARGA DISKON (Rp) - Opsional</label>
                            <input type="number" name="discount_price" class="form-control" value="{{ $product->discount_price }}" placeholder="Kosongkan jika tidak ada diskon">
                            <small class="text-muted italic">Isi jika ingin menampilkan harga diskon.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Stok</label>
                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} id="isActive">
                        <label class="form-check-label fw-bold" for="isActive">Status Aktif</label>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-light px-4">Kembali</a>
                        <button type="submit" class="btn btn-success px-5 fw-bold">Update Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection