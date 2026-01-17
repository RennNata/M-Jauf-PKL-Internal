@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="container py-5">
    {{-- Progress Header --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 text-center">
            <h1 class="display-6 fw-bold text-dark">Selesaikan Pesanan</h1>
            <p class="text-muted">Tinggal selangkah lagi untuk mendapatkan tanaman impianmu.</p>
            <div class="d-flex justify-content-center align-items-center mt-4">
                <div class="d-flex align-items-center text-success">
                    <span class="badge bg-success rounded-circle me-2">1</span> <small class="fw-bold">Keranjang</small>
                </div>
                <div class="mx-3 border-top border-2" style="width: 50px;"></div>
                <div class="d-flex align-items-center text-success">
                    <span class="badge bg-success rounded-circle me-2">2</span> <small class="fw-bold">Checkout</small>
                </div>
                <div class="mx-3 border-top border-2" style="width: 50px;"></div>
                <div class="d-flex align-items-center text-muted">
                    <span class="badge bg-secondary rounded-circle me-2">3</span> <small>Pembayaran</small>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- Bagian Kiri: Alamat & Informasi --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-success-subtle p-2 rounded-3 me-3">
                                <i class="bi bi-geo-alt text-success fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Informasi Pengiriman</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Penerima</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                       class="form-control rounded-3 px-3 @error('name') is-invalid @enderror" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">+62</span>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                           class="form-control rounded-end-3 px-3 @error('phone') is-invalid @enderror" placeholder="8xxxxxxxxxx" required>
                                </div>
                                @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Alamat Lengkap</label>
                                <textarea name="address" rows="4" class="form-control rounded-4 px-3 @error('address') is-invalid @enderror" 
                                          placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, dan kelurahan" required>{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Opsi Pengiriman (Visual Only) --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-subtle p-2 rounded-3 me-3">
                                <i class="bi bi-truck text-primary fs-4"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Metode Pengiriman</h5>
                        </div>
                        <div class="p-3 border border-success border-2 rounded-4 bg-success-subtle position-relative">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success fs-5 me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-0">Kurir Express</h6>
                                    <small class="text-muted">Estimasi tiba dalam 1-2 hari</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Ringkasan & Submit --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow rounded-4 sticky-top" style="top: 100px; z-index: 10;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                        
                        <div class="order-items mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($cart->items as $item)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="position-relative">
                                        @php
                                            $img = $item->product->primaryImage ?? $item->product->images->first();
                                            $imgPath = $img ? $img->image_path : null;
                                        @endphp
                                        <img src="{{ $imgPath ? asset('storage/' . $imgPath) : 'https://placehold.co/100x100?text=No+Photo' }}"
                                        class="rounded shadow-sm border me-3"
                                        width="70" height="70" style="object-fit: cover;">
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <h6 class="small fw-bold mb-0 text-truncate" style="max-width: 150px;">{{ $item->product->name }}</h6>
                                        <small class="text-muted">Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="small fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr class="dashed text-muted">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Quantity</span>
                            <span class="fw-bold text-dark">{{ $cart->items->sum('quantity') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold text-dark">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Biaya Kirim</span>
                            <span class="text-success fw-bold">GRATIS</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-3 p-3 bg-light rounded-3">
                            <span class="fw-bold h5 mb-0">Total Tagihan</span>
                            <span class="fw-bold h5 mb-0 text-success">
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold shadow mt-4 animate__animated animate__pulse animate__infinite">
                            Konfirmasi & Bayar
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-shield-lock-fill me-1"></i> Pembayaran Aman & Terenkripsi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .dashed { border-top: 2px dashed #dee2e6; }
    .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1);
    }
    .order-items::-webkit-scrollbar { width: 5px; }
    .order-items::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }
</style>
@endsection