@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    {{-- Breadcrumb Modern --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb p-2 bg-light rounded-3">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-success">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-decoration-none text-success">Katalog</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name, 20) }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Product Images Gallery --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Main Image Display --}}
                <div class="position-relative p-3 text-center bg-white">
                    @php
                        $mainImg = $product->primaryImage ?? $product->images->first();
                        $mainPath = $mainImg ? $mainImg->image_path : null;
                    @endphp
                    <img src="{{ $mainPath ? asset('storage/' . $mainPath) : 'https://placehold.co/600x600?text=No+Photo' }}"
                         id="main-image"
                         class="img-fluid rounded-3"
                         alt="{{ $product->name }}"
                         style="max-height: 500px; width: 100%; object-fit: contain;">

                    @if($product->has_discount)
                        <span class="badge bg-danger position-absolute top-0 start-0 m-4 px-3 py-2 fs-6 rounded-pill shadow">
                            Hemat {{ $product->discount_percentage }}%
                        </span>
                    @endif
                </div>

                {{-- Thumbnails --}}
                @if($product->images->count() > 1)
                    <div class="card-footer bg-white border-0 pb-4">
                        <div class="d-flex gap-2 justify-content-center overflow-auto py-2">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     class="rounded border thumb-img {{ $loop->first ? 'active-thumb' : '' }}"
                                     style="width: 70px; height: 70px; object-fit: cover; cursor: pointer; transition: 0.3s;"
                                     onclick="changeImage(this)">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Product Action & Details --}}
        <div class="col-lg-6">
            <div class="ps-lg-3">
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
                   class="text-success text-decoration-none fw-bold small text-uppercase tracking-wider mb-2 d-block">
                    {{ $product->category->name }}
                </a>
                <h1 class="display-6 fw-bold text-dark mb-3">{{ $product->name }}</h1>

                <div class="d-flex align-items-center mb-4">
                    <div class="me-4">
                        @if($product->has_discount)
                            <span class="text-muted text-decoration-line-through fs-5 me-2">
                                {{ $product->formatted_original_price }}
                            </span>
                        @endif
                        <span class="h2 fw-bold text-success mb-0">
                            {{ $product->formatted_price }}
                        </span>
                    </div>
                    <div class="border-start ps-3">
                        @if($product->stock > 0)
                            <span class="text-success small fw-bold"><i class="bi bi-check2-circle me-1"></i> Tersedia ({{ $product->stock }})</span>
                        @else
                            <span class="text-danger small fw-bold"><i class="bi bi-x-circle me-1"></i> Stok Habis</span>
                        @endif
                    </div>
                </div>

                <p class="text-muted mb-4 lh-lg">
                    {!! nl2br(e($product->description)) !!}
                </p>

                {{-- Transaction Box --}}
                <div class="card border-0 bg-light rounded-4 p-4 mb-4">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Jumlah</label>
                                <div class="input-group border rounded-pill bg-white overflow-hidden">
                                    <button type="button" class="btn btn-link text-dark text-decoration-none px-3" onclick="updateQty(-1)">-</button>
                                    <input type="number" name="quantity" id="quantity"
                                           value="1" min="1" max="{{ $product->stock }}"
                                           class="form-control border-0 text-center fw-bold" readonly>
                                    <button type="button" class="btn btn-link text-dark text-decoration-none px-3" onclick="updateQty(1)">+</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label d-none d-md-block">&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill fw-bold shadow-sm"
                                        @if($product->stock == 0) disabled @endif>
                                    <i class="bi bi-bag-plus-fill me-2"></i> Tambah Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="d-flex gap-3">
                    @auth
                        <button type="button" 
                                onclick="toggleWishlist({{ $product->id }})"
                                class="btn btn-outline-danger flex-grow-1 rounded-pill py-2 wishlist-btn-{{ $product->id }}">
                            <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill' : 'bi-heart' }} me-2"></i>
                            Wishlist
                        </button>
                    @endauth
                    <a href="https://wa.me/628123456789?text=Halo, saya tanya produk {{ $product->name }}" 
                       target="_blank"
                       class="btn btn-outline-success rounded-circle p-2 px-3">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>

                <div class="mt-5 pt-3 border-top">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-truck fs-4 me-3 text-success"></i>
                                <span>Pengiriman Aman & Bergaransi</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="bi bi-shield-check fs-4 me-3 text-success"></i>
                                <span>Tanaman Pilihan Terbaik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .thumb-img:hover, .active-thumb {
        border-color: #198754 !important;
        opacity: 0.8;
        transform: translateY(-3px);
    }
    .active-thumb { border-width: 2px !important; }
    input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>

@push('scripts')
<script>
    function changeImage(element) {
        document.getElementById('main-image').src = element.src;
        document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active-thumb'));
        element.classList.add('active-thumb');
    }

    function updateQty(delta) {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        let newVal = parseInt(input.value) + delta;
        if (newVal >= 1 && newVal <= max) {
            input.value = newVal;
        }
    }
</script>
@endpush
@endsection