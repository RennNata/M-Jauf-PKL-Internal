@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <div class="row g-4 ">
        <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1 text-dark">Wishlist Saya</h1>
            <p class="text-muted mb-0">Produk yang kamu incar tersimpan di sini.</p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill">
            {{ $cart->items->count() }} Item
        </span>
    </div>

        @if($cart && $cart->items->count())
            {{-- Cart Items List --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">Produk</th>
                                    <th class="text-center py-3 border-0">Harga</th>
                                    <th class="text-center py-3 border-0">Jumlah</th>
                                    <th class="text-end pe-4 py-3 border-0">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center py-2">
                                                @php
                                                    $img = $item->product->primaryImage ?? $item->product->images->first();
                                                    $imgPath = $img ? $img->image_path : null;
                                                @endphp
                                                <img src="{{ $imgPath ? asset('storage/' . $imgPath) : 'https://placehold.co/100x100?text=No+Photo' }}"
                                                     class="rounded shadow-sm border me-3"
                                                     width="70" height="70" style="object-fit: cover;">
                                                <div>
                                                    <a href="{{ route('catalog.show', $item->product->slug) }}"
                                                       class="text-decoration-none text-dark fw-bold mb-1 d-block hover-success">
                                                        {{ Str::limit($item->product->name, 35) }}
                                                    </a>
                                                    <small class="text-muted bg-light px-2 py-1 rounded">
                                                        {{ $item->product->category->name }}
                                                    </small>
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="mt-1">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-link btn-sm text-danger p-0 text-decoration-none" onclick="return confirm('Hapus dari keranjang?')">
                                                            <i class="bi bi-trash3 me-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-muted">
                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <div class="input-group input-group-sm mx-auto" style="width: 100px;">
                                                    <input type="number" name="quantity"
                                                           value="{{ $item->quantity }}"
                                                           min="1" max="{{ $item->product->stock }}"
                                                           class="form-control text-center border-light bg-light"
                                                           onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td class="text-end pe-4 fw-bold text-dark fs-6">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sticky Order Summary --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-3 position-sticky" style="top: 100px;">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h5 class="mb-0 fw-bold">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Harga ({{ $cart->items->sum('quantity') }} item)</span>
                            <span class="text-dark">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Admin</span>
                            <span class="text-success fw-medium">Gratis</span>
                        </div>
                        <hr class="border-light">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total Bayar</span>
                            <span class="fw-bold text-success fs-5">
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 btn-lg fw-bold shadow-sm mb-2 rounded-pill">
                            Beli Sekarang ({{ $cart->items->count() }})
                        </a>
                        <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary w-100 border-0">
                            <i class="bi bi-arrow-left me-2"></i>Lanjut Pilih Tanaman
                        </a>
                    </div>
                </div>
            </div>
        @else
            {{-- Empty Cart State --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                    <div class="card-body py-5">
                        <div class="mb-4">
                            <div class="bg-light d-inline-block p-4 rounded-circle">
                                <i class="bi bi-cart-fill text-muted" style="font-size: 3rem;"></i>
                            </div>
                        </div>      
                        <h4 class="fw-bold">Keranjangmu masih kosong</h4>
                        <p class="text-muted">Yuk, isi dengan tanaman cantik pilihanmu!</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-success px-5 py-2 mt-2 rounded-pill fw-bold shadow-sm">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .hover-success:hover { color: #198754 !important; }
    .table > :not(caption) > * > * { border-bottom-width: 1px; border-color: #f8f9fa; }
</style>
@endsection