@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                <h5 class="mb-0 text-success fw-bold">Kategori Tanaman</h5>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success px-3">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted uppercase" style="font-size: 0.8rem;">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th class="ps-1">Kategori</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Total Produk</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">{{ $category->id }}</td>
                                <td class="ps-1">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $category->image ? asset('storage/'.$category->image) : 'https://via.placeholder.com/50' }}" 
                                             class="rounded me-3 border" width="45" height="45" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $category->name }}</div>
                                            <small class="text-muted">{{ $category->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><small class="text-truncate d-inline-block" style="max-width: 250px;">{{ $category->description ?? '-' }}</small></td>
                                <td class="text-center">
                                    <span class="badge {{ $category->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-center"><span class="badge bg-light text-dark border px-3">{{ $category->products_count }} Item</span></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus? Pastikan tidak ada produk di dalamnya.')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger ms-1"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada kategori.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-0">{{ $categories->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>
@endsection