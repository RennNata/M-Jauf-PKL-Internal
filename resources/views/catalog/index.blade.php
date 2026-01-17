@extends('layouts.app')

@section('title', 'Katalog Produk - PlantShop')

@section('content')
<div class="bg-light py-4 border-bottom mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Katalog</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container pb-5">
    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 10;">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="bi bi-filter-left me-2"></i>Filter Produk
                </div>
                <div class="card-body">
                    <form action="{{ route('catalog.index') }}" method="GET">
                        {{-- Search Hidden --}}
                        @if(request('q')) 
                            <input type="hidden" name="q" value="{{ request('q') }}"> 
                        @endif

                        {{-- Filter Kategori --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Kategori</h6>
                            <div class="list-group list-group-flush">
                                <label class="list-group-item border-0 ps-0">
                                    <input class="form-check-input me-2" type="radio" name="category" value="" 
                                        {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()">
                                    Semua Kategori
                                </label>
                                @foreach($categories as $cat)
                                    <label class="list-group-item border-0 ps-0 d-flex justify-content-between align-items-center">
                                        <span>
                                            <input class="form-check-input me-2" type="radio" name="category" value="{{ $cat->slug }}"
                                                {{ request('category') == $cat->slug ? 'checked' : '' }}
                                                onchange="this.form.submit()">
                                            {{ $cat->name }}
                                        </span>
                                        <span class="badge bg-light text-dark rounded-pill border">{{ $cat->products_count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Filter Harga --}}
                        <div class="mb-4 border-top pt-4">
                            <h6 class="fw-bold mb-3">Rentang Harga (Rp)</h6>
                            <div class="mb-2">
                                <input type="number" name="min_price" class="form-control form-control-sm mb-2" 
                                       placeholder="Harga Min" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="form-control form-control-sm" 
                                       placeholder="Harga Maks" value="{{ request('max_price') }}">
                            </div>
                            <button type="submit" class="btn btn-success w-100 btn-sm fw-bold">Terapkan</button>
                        </div>

                        <a href="{{ route('catalog.index') }}" class="btn btn-link text-danger text-decoration-none w-100 btn-sm mt-1">
                            <i class="bi bi-x-circle me-1"></i>Reset Filter
                        </a>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                    <p class="mb-0 text-muted small">
                        Menampilkan <span class="fw-bold text-dark">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> 
                        dari <span class="fw-bold text-dark">{{ $products->total() }}</span> produk
                    </p>
                    
                    {{-- Sorting --}}
                    <form method="GET" class="d-flex align-items-center">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <label class="me-2 small text-muted d-none d-md-block">Urutkan:</label>
                        <select name="sort" class="form-select form-select-sm border-0 bg-light" style="width: auto;" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                        </select>
                    </form>
                </div>
            </div>

            @if(request('q'))
                <div class="alert alert-light border-0 shadow-sm mb-4">
                    Hasil pencarian untuk: <strong class="text-success">"{{ request('q') }}"</strong>
                </div>
            @endif

            <div class="row row-cols-2 row-cols-md-3 g-3 g-md-4 justify-content-center">
                @forelse($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-search-heart text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="fw-bold">Produk Tidak Ditemukan</h5>
                        <p class="text-muted">Maaf, kami tidak menemukan produk yang cocok dengan filter kamu.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-success px-4">Lihat Semua Produk</a>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection