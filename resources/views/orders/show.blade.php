@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            {{-- Navigation & Action --}}
            <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
                <a href="{{ route('orders.index') }}" class="btn btn-light rounded-pill px-3 shadow-sm border">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-3 shadow-sm">
                    <i class="bi bi-printer me-1"></i> Cetak Invoice
                </button>
            </div>

            <div class="card shadow border-0 rounded-4 overflow-hidden animate__animated animate__fadeInUp">
                {{-- Header Section --}}
                <div class="card-header bg-success p-4 p-md-5 text-white border-0">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-center text-md-start">
                            <h6 class="text-uppercase ls-wide opacity-75 mb-1 small fw-bold">Rincian Pesanan</h6>
                            <h2 class="fw-bold mb-0">#{{ $order->order_number }}</h2>
                            <p class="mb-0 opacity-75 small italic">
                                <i class="bi bi-calendar3 me-1"></i> {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB
                            </p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            @php
                                $statusMap = [
                                    'pending' => ['bg-warning', 'Menunggu Pembayaran'],
                                    'processing' => ['bg-info', 'Sedang Diproses'],
                                    'shipped' => ['bg-primary', 'Dalam Pengiriman'],
                                    'delivered' => ['bg-success', 'Pesanan Selesai'],
                                    'cancelled' => ['bg-danger', 'Dibatalkan'],
                                ];
                                $style = $statusMap[$order->status] ?? ['bg-secondary', 'Unknown'];
                            @endphp
                            <span class="badge rounded-pill px-4 py-2 fs-6 shadow-sm {{ $style[0] }}">
                                {{ $style[1] }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    {{-- Table Section --}}
                    <div class="p-4 p-md-5">
                        <div class="table-responsive">
                            <table class="table table-borderless align-middle">
                                <thead class="border-bottom text-muted small">
                                    <tr>
                                        <th class="pb-3 text-uppercase fw-bold">Produk</th>
                                        <th class="pb-3 text-center text-uppercase fw-bold">Qty</th>
                                        <th class="pb-3 text-end text-uppercase fw-bold">Harga</th>
                                        <th class="pb-3 text-end text-uppercase fw-bold">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr class="border-bottom-dashed">
                                        <td class="py-4">
                                            <div class="d-flex align-items-center text-start text-md-start">
                                                <div class="bg-light rounded-3 p-2 me-3 d-none d-sm-block">
                                                    <i class="bi bi-flower1 text-success fs-4"></i>
                                                </div>
                                                <span class="fw-bold text-dark fs-6">{{ $item->product_name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center py-4 fw-medium">{{ $item->quantity }}</td>
                                        <td class="text-end py-4 text-muted small">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-end py-4 fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Calculation Summary --}}
                        <div class="row justify-content-end mt-4">
                            <div class="col-md-5 col-lg-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Subtotal:</span>
                                    <span class="fw-bold">Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Biaya Kirim:</span>
                                    <span class="fw-bold">{{ $order->shipping_cost > 0 ? 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') : 'Gratis' }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-3">
                                    <span class="fw-bold text-dark fs-5">Total Bayar:</span>
                                    <span class="fw-bold text-success fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Info Section --}}
                    <div class="bg-light p-4 p-md-5">
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <h6 class="text-uppercase fw-bold small text-muted mb-3"><i class="bi bi-geo-alt-fill me-1"></i> Alamat Pengiriman</h6>
                                <p class="fw-bold text-dark mb-1 fs-5">{{ $order->shipping_name }}</p>
                                <p class="text-muted mb-1"><i class="bi bi-telephone me-2"></i> {{ $order->shipping_phone }}</p>
                                <p class="text-muted mb-0 lh-base" style="max-width: 300px;">{{ $order->shipping_address }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="text-uppercase fw-bold small text-muted mb-3"><i class="bi bi-info-circle-fill me-1"></i> Info Tambahan</h6>
                                <p class="small text-muted mb-1">Status Pembayaran:</p>
                                <span class="badge rounded-pill {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                    {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Button Section --}}
                @if(isset($snapToken) && $order->status === 'pending')
                <div class="card-footer bg-white py-5 text-center border-0 shadow-lg position-relative" style="z-index: 5;">
                    <div class="mx-auto mb-4 animate__animated animate__pulse animate__infinite" style="max-width: 500px;">
                        <div class="alert alert-warning border-0 shadow-sm rounded-4">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            Segera selesaikan pembayaran Anda untuk memproses pesanan ini.
                        </div>
                    </div>
                    <button id="pay-button" class="btn btn-success btn-lg px-5 py-3 rounded-pill fw-bold shadow-lg transition-all hover-scale">
                        <i class="bi bi-credit-card-2-front me-2"></i> BAYAR SEKARANG
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .border-bottom-dashed { border-bottom: 1px dashed #dee2e6; }
    .hover-scale:hover { transform: scale(1.05); }
    .transition-all { transition: all 0.3s ease; }
    
    @media print {
        .btn, .card-footer, .alert { display: none !important; }
        .card { box-shadow: none !important; border: 1px solid #ddd !important; }
        .container { width: 100% !important; max-width: 100% !important; padding: 0 !important; }
    }
</style>

@if(isset($snapToken))
    @push('scripts')
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');
                if (payButton) {
                    payButton.addEventListener('click', function() {
                        payButton.disabled = true;
                        payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghubungkan...';

                        window.snap.pay('{{ $snapToken }}', {
                            onSuccess: (result) => window.location.href = '{{ route("orders.success", $order) }}',
                            onPending: (result) => window.location.href = '{{ route("orders.pending", $order) }}',
                            onError: (result) => {
                                alert('Pembayaran gagal!');
                                payButton.disabled = false;
                                payButton.innerHTML = '<i class="bi bi-credit-card-2-front me-2"></i> BAYAR SEKARANG';
                            },
                            onClose: () => {
                                payButton.disabled = false;
                                payButton.innerHTML = '<i class="bi bi-credit-card-2-front me-2"></i> BAYAR SEKARANG';
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
@endif
@endsection