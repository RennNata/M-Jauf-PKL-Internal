{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama website Toko Tanaman Hias
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda - Segarkan Rumah Anda')

@push('styles')
<style>
    /* Custom CSS untuk tema tanaman */
    :root {
        --plant-dark: #1e5128;
        --plant-leaf: #4e944f;
        --plant-light: #b4e197;
        --plant-soft: #f8f9fa;
    }

    .hero-section {
        background: linear-gradient(135deg, var(--plant-dark) 0%, var(--plant-leaf) 100%);
        padding: 60px 0;
        border-radius: 0 0 50px 50px;
    }

    .category-card {
        transition: all 0.3s ease;
        border-radius: 20px !important;
        display: flex;
        height: 100%; 
        flex-direction: column;
        overflow: hidden;
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .category-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        object-position: center;
        border-bottom: 4px solid var(--plant-soft);
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-img {
        transform: scale(1.1);
    }

    .btn-plant {
        background-color: #ffcc00;
        color: var(--plant-dark);
        font-weight: bold;
        border-radius: 30px;
        padding: 12px 30px;
        transition: all 0.3s;
    }

    .btn-plant:hover {
        background-color: #00b13b;
        transform: scale(1.05);
    }

    .section-title {
        font-weight: 800;
        color: var(--plant-dark);
        position: relative;
        display: inline-block;
        margin-bottom: 30px;
    }

    .section-title::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 4px;
        background: var(--plant-leaf);
        bottom: -10px;
        left: 0;
        border-radius: 2px;
    }

    .promo-card {
        border-radius: 25px;
        border: none;
        transition: transform 0.3s;
    }

    .promo-card:hover {
        transform: scale(1.02);
    }
</style>
@endpush

@section('content')
    {{-- Hero Section --}}
<section class="hero-section text-white mb-2">
    <div class="container">
        <div class="row align-items-center">
            {{-- Bagian Teks (3/10) --}}
            <div class="col-lg-4 col-md-5">
                <span class="badge bg-light text-success mb-3 px-3 py-2 rounded-pill fw-bold">Premium Quality Plants</span>
                <h1 class="display-5 fw-bold mb-3">Hadirkan Kesegaran Alam</h1>
                <p class="mb-4 opacity-75">Percantik sudut ruangan dan segarkan udara di sekitar Anda.</p>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('catalog.index') }}" class="btn btn-plant shadow w-100">
                        <i class="bi bi-cart-plus me-2"></i>Mulai Belanja
                    </a>
                </div>
            </div>

            {{-- Bagian Carousel (7/10) --}}
            <div class="col-lg-8 col-md-7">
                <div id="carouselExampleAutoplaying" class="carousel slide shadow-lg rounded-4 overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a href="https://www.kelaspintar.id/blog/tips-pintar/pengertian-dan-jenis-tanaman-hias-11823">
                                <img src="{{ asset('storage/Hero/hero1.jpg') }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="...">
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="https://www.megainsurance.co.id/detailpost/merawat-tanaman">
                                <img src="{{ asset('storage/Hero/hero2.png') }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="...">
                            </a>
                        </div>
                    </div>
                    {{-- Controls --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Kategori Populer --}}
<section id="kategori" class="py-5">
    <div class="container text-center ">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">Kategori Tanaman</h2>
        </div>
        <div class="row g-4 mt-2 justify-content-center">
            @foreach($categories->take(4) as $category)
                <div class="col-6 col-md-3">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm category-card h-300">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('assets/images/default.jpg') }}" 
                                 class="category-img mb-3 w-100" 
                                 alt="{{ $category->name }}">
                            <h5 class="card-title text-dark fw-bold mb-1 pt-2">{{ $category->name }}</h5>
                            <p class="text-success small mb-0 pt-2 pb-3">{{ $category->products_count }} Spesies</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

        {{-- Produk Unggulan --}}
<section class="py-5 bg-light shadow-sm">
    <div class="container">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="mb-0 fw-bold" style="color: var(--plant-dark);">Koleksi Unggulan</h2>
                <p class="text-muted">Pilihan terbaik berdasarkan pembelian terbanyak</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                Lihat Semua <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        {{-- Grid Produk --}}
        <div class="row g-4 justify-content-center">
            @foreach($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3"> {{-- col-lg-3 artinya 4 card per baris --}}
                    <div class="card product-card h-100 border-0 shadow-sm position-relative">
                        {{-- Image Container --}}
                        <div class="position-relative overflow-hidden" style="border-radius: 15px 15px 0 0;">
                            <a href="{{ route('catalog.show', $product->slug) }}">
                                {{-- Gunakan fallback jika image null --}}
                                <img src="{{ $product->primaryImage ? $product->primaryImage->image_url : asset('assets/images/default.jpg') }}"
                                     class="card-img-top" 
                                     alt="{{ $product->name }}" 
                                     style="height: 250px; object-fit: cover;">
                            </a>
                            
                            {{-- Wishlist Button --}}
                            <button type="button" 
                                    onclick="event.preventDefault(); toggleWishlist({{ $product->id }})" 
                                    class="btn btn-white shadow-sm position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn-{{ $product->id }}"
                                    style="z-index: 10; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi {{ Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-5"></i>
                            </button>
                        </div>

                        <div class="card-body">
                            <small class="text-muted d-block mb-1">{{ $product->category->name }}</small>
                            <h6 class="fw-bold mb-2">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="text-dark text-decoration-none">
                                    {{ Str::limit($product->name, 35) }}
                                </a>
                            </h6>
                            {{-- Badge Diskon --}}
                            @if($product->has_discount)
                            <span class="badge-discount">
                            -{{ $product->discount_percentage }}%
                            </span>
                            @endif
                            <div class="mt-auto">
                            @if($product->has_discount)
                                <small class="text-muted text-decoration-line-through">
                                {{ $product->formatted_original_price }}
                                </small>
                            @endif
                                <div class="fw-bold text-success">
                                    {{ $product->formatted_price }}
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pb-3">
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold" @if($product->stock == 0) disabled @endif>
                                    <i class="bi bi-cart-plus me-2"></i>
                                    {{ $product->stock == 0 ? 'Habis' : 'Keranjang' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

    {{-- Promo Banner --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card bg-success text-white promo-card shadow" style="min-height: 220px;">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <h3 class="fw-bold">Tips Perawatan</h3>
                            <p>Gratis panduan perawatan tanaman untuk setiap pembelian pertama!</p>
                            <a href="#" class="btn btn-light text-success fw-bold w-fit" style="width: fit-content;">
                                Pelajari Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-dark text-white promo-card shadow" style="min-height: 220px;">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <h3 class="fw-bold text-warning">Flash Sale Weekend!</h3>
                            <p>Dapatkan diskon hingga 40% untuk tanaman Indoor tertentu.</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-warning fw-bold w-fit" style="width: fit-content;">
                                Cek Promo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Terbaru --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title mb-5">Baru Saja Tiba</h2>
            <div class="row g-4">
                @foreach($latestProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('profile.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection