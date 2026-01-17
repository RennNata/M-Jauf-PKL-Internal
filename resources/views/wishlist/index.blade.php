@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1 text-dark">Wishlist Saya</h1>
            <p class="text-muted mb-0">Produk yang kamu incar tersimpan di sini.</p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">
            {{ $products->count() }} Item
        </span>
    </div>

    @if($products->count())
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($products as $product)
                <div class="col">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body py-5">
                <div class="mb-4">
                    <div class="bg-light d-inline-block p-4 rounded-circle">
                        <i class="bi bi-heart-fill text-muted" style="font-size: 3rem;"></i>
                    </div>
                </div>
                <h3 class="h4 fw-bold text-dark">Belum ada barang impian?</h3>
                <p class="text-muted mb-4">Simpan produk favoritmu agar lebih mudah membelinya nanti.</p>
                <a href="{{ route('catalog.index') }}" class="btn btn-success px-5 py-2 fw-bold shadow-sm rounded-pill">
                    Eksplor Tanaman Sekarang
                </a>
            </div>
        </div>
    @endif
</div>
@endsection