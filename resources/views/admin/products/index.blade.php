@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                <h5 class="mb-0 text-success fw-bold">Daftar Produk</h5>
                
                <div class="d-flex gap-2">
                    {{-- Filter Kategori --}}
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-filter"></i> {{ request('category') ? $categories->firstWhere('slug', request('category'))->name : 'Semua Kategori' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('admin.products.index') }}">Semua Kategori</a></li>
                            @foreach($categories as $category)
                                <li><a class="dropdown-item" href="{{ route('admin.products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    
                    {{-- GANTI KE LINK --}}
                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-lg"></i> Tambah Produk
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th class="ps-1">Produk</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Harga Diskon</th>
                                <th class="text-center">Stok</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="ps-4">{{ $product->id }}</td>
                                <td class="ps-1">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . ($product->primaryImage->image_path ?? 'products/default.png')) }}"
                                             class="rounded me-3 border" width="45" height="45" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold">{{ $product->name }}</div>
                                            <small class="text-muted">{{ $product->weight }} gr</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><span class="badge bg-light text-dark border">{{ $product->category->name }}</span></td>
                                <td class="text-center">
                                    <span class="badge {{ $product->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                
                                <td class="text-center fw-bold text-success">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="text-center fw-bold text-success">
                                    @if($product->has_discount)
                                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-info-subtle text-info px-3">{{ $product->stock }}</span></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        {{-- TOMBOL EDIT JADI LINK --}}
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5 text-muted">Belum ada produk.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0">{{ $products->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
@endsection