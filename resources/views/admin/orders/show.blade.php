@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="mb-4 d-flex align-items-center">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light border rounded me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h3 class="h4 mb-0 fw-bold text-dark">Detail Pesanan <span class="text-success">#{{ $order->order_number }}</span></h3>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        {{-- List Item --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold">Ringkasan Produk</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light small">
                            <tr>
                                <th class="ps-4">Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center py-2">
                                    @php
                                        $productImage = $item->product->primaryImage ?? $item->product->images->first();
                                        $pathDB = $productImage ? $productImage->image_path : null;
                                    @endphp

                                    <img src="{{ $pathDB ? asset('storage/' . $pathDB) : 'https://placehold.co/100x100?text=No+Photo' }}" 
                                        class="rounded border me-3" 
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                    
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">{{ $item->product->name }}</h6>
                                        {{-- Baris di bawah ini untuk bantu kamu cek: --}}
                                        <small class="text-muted d-block">ID Produk: {{ $item->product_id }}</small>
                                        <small class="text-info" style="font-size: 0.7rem;">DB Column: {{ $pathDB ?? 'KOSONG DI DB' }}</small>
                                    </div>
                                </div> 
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end text-muted">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold pe-4 text-dark">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="ps-4 py-3 fw-bold text-dark fs-5 text-uppercase">Total Pembayaran</td>
                                <td class="text-end pe-4 py-3 fw-bold fs-5 text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Info Pengiriman & Catatan --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2 text-success"></i>Alamat Pengiriman</h6>
                <div class="p-3 bg-light rounded border border-dashed">
                    {{-- Pastikan kamu punya kolom address di tabel order atau relasi user --}}
                    <p class="mb-0 text-muted">{{ $order->shipping_address ?? 'Alamat tidak dicantumkan' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Info Customer --}}
        <div class="card shadow-sm border-0 mb-4 px-2 py-1">
            <div class="card-body">
                <h6 class="fw-bold mb-3 text-uppercase small text-muted">Informasi Pelanggan</h6>
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                    <div class="avatar me-3 bg-dark text-white rounded d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 50px; height: 50px;">
                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">{{ $order->user->name }}</h6>
                        <small class="text-muted">Member Sejak {{ $order->user->created_at->format('Y') }}</small>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="small text-muted d-block">Email:</label>
                    <span class="text-dark">{{ $order->user->email }}</span>
                </div>
                <div>
                    <label class="small text-muted d-block">Nomor HP:</label>
                    <span class="text-dark">{{ $order->shipping_phone ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Action Card --}}
        <div class="card shadow-sm border-0" style="background: #f8fafc;">
            <div class="card-body">
                <h6 class="fw-bold mb-3 d-flex align-items-center">
                    <span class="p-2 bg-white rounded shadow-sm me-2"><i class="bi bi-gear text-primary"></i></span>
                    Status Pesanan
                </h6>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf @method('PATCH')

                    <div class="mb-4">
                        <select name="status" class="form-select border-0 shadow-sm py-2">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🕒 Pending (Menunggu)</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>📦 Processing (Dikemas)</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Shipped (Dikirim)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Completed (Selesai)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled (Batalkan)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm py-2">
                        UPDATE STATUS
                    </button>
                </form>

                @if($order->status == 'cancelled')
                    <div class="alert alert-danger mt-3 mb-0 small border-0 shadow-sm">
                        <i class="bi bi-exclamation-octagon-fill me-1"></i> Pesanan dibatalkan. Stok otomatis kembali.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection