@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">

            {{-- Header --}}
            <div class="p-5 mb-5 rounded-4 shadow-sm position-relative overflow-hidden animate__animated animate__fadeInDown" 
                 style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                <div class="position-relative z-1 text-white">
                    <h1 class="display-5 fw-bold mb-2">Halo, {{ auth()->user()->name }}! 👋</h1>
                    <p class="lead opacity-75">Status pesananmu akan terupdate otomatis di sini.</p>
                </div>
                <i class="bi bi-truck position-absolute text-white opacity-25" 
                   style="font-size: 15rem; right: -30px; bottom: -50px; transform: rotate(-15deg);"></i>
            </div>

            @if($orders->isEmpty())
                {{-- Empty State (Sama seperti sebelumnya) --}}
                <div class="text-center py-5">...</div>
            @else
                
                <div class="row g-4">
                    @foreach($orders as $order)
                    <div class="col-12 animate__animated animate__fadeInUp">
                        <div class="card border-0 shadow-sm rounded-4 hover-card transition-all overflow-hidden">
                            <div class="card-body p-0">
                                
                                {{-- Header Kartu --}}
                                <div class="p-4 d-flex flex-wrap justify-content-between align-items-center border-bottom bg-white">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success text-white p-2 rounded-3 me-3 shadow-sm">
                                            <i class="bi bi-receipt fs-4"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted small fw-bold">NO. PESANAN</span>
                                            <h5 class="mb-0 fw-bold text-dark">#{{ $order->order_number }}</h5>
                                        </div>
                                    </div>
                                    <div class="text-md-end mt-3 mt-md-0">
                                        {{-- Badge Status Utama --}}
                                        @if($order->status == 'cancelled')
                                            <span class="badge bg-danger px-3 py-2 rounded-pill">Dibatalkan</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-info px-3 py-2 rounded-pill">Sedang Diproses</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">Dalam Pengiriman</span>
                                        @elseif($order->status == 'completed')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Pesanan Selesai</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-success border border-success px-3 py-2 rounded-pill">
                                                <i class="bi bi-hourglass me-1"></i> {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Progress Tracker (DIPERBAIKI LOGIKANYA) --}}
                                <div class="px-4 py-5 bg-light-subtle {{ $order->status == 'cancelled' ? 'opacity-50' : '' }}">
                                    <div class="row text-center position-relative">
                                        
                                        {{-- Logic Persentase Bar --}}
                                        @php
                                            $progress = 0;
                                            if($order->status == 'pending') $progress = 0;
                                            elseif($order->status == 'processing') $progress = 33;
                                            elseif($order->status == 'shipped') $progress = 66;
                                            elseif(in_array($order->status, ['delivered', 'completed'])) $progress = 100;
                                        @endphp

                                        <div class="progress position-absolute top-50 start-50 translate-middle" style="height: 4px; width: 70%; z-index: 0;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>
                                        </div>

                                        {{-- Steps --}}
                                        <div class="col-3 position-relative z-1">
                                            <div class="step-icon mx-auto mb-2 rounded-circle border-4 {{ in_array($order->status, ['pending','processing','shipped','delivered','completed']) ? 'bg-success text-white border-success' : 'bg-white text-muted border-light' }}">
                                                <i class="bi bi-wallet2"></i>
                                            </div>
                                            <span class="small fw-bold">Menunggu</span>
                                        </div>
                                        <div class="col-3 position-relative z-1">
                                            <div class="step-icon mx-auto mb-2 rounded-circle border-4 {{ in_array($order->status, ['processing','shipped','delivered','completed']) ? 'bg-success text-white border-success' : 'bg-white text-muted border-light' }}">
                                                <i class="bi bi-gear-wide-connected"></i>
                                            </div>
                                            <span class="small fw-bold">Diproses</span>
                                        </div>
                                        <div class="col-3 position-relative z-1">
                                            <div class="step-icon mx-auto mb-2 rounded-circle border-4 {{ in_array($order->status, ['shipped','delivered','completed']) ? 'bg-success text-white border-success' : 'bg-white text-muted border-light' }}">
                                                <i class="bi bi-truck"></i>
                                            </div>
                                            <span class="small fw-bold">Dikirim</span>
                                        </div>
                                        <div class="col-3 position-relative z-1">
                                            <div class="step-icon mx-auto mb-2 rounded-circle border-4 {{ in_array($order->status, ['delivered','completed']) ? 'bg-success text-white border-success' : 'bg-white text-muted border-light' }}">
                                                <i class="bi bi-check-all"></i>
                                            </div>
                                            <span class="small fw-bold">Selesai</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer Kartu --}}
                                <div class="p-4 bg-white border-top d-flex flex-wrap justify-content-between align-items-center">
                                    <div>
                                        <span class="text-muted small">Total Tagihan</span>
                                        <h4 class="mb-0 fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="mt-3 mt-md-0">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
                                            Lihat Detail <i class="bi bi-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Styling tetap sama agar konsisten */
    .transition-all { transition: all 0.3s ease-in-out; }
    .hover-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .step-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; background: white; transition: 0.5s; }
    .bg-light-subtle { background-color: #f8f9fa; }
    .progress-bar { transition: width 1.5s ease; }
</style>
@endsection