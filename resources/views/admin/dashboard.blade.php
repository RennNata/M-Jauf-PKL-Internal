@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- CSS Khusus untuk Efek Halus --}}
    <style>
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: translateY(-5px); }
        .card { border-radius: 12px; }
    </style>

    <div class="row g-4 mb-4">
        {{-- Stats Cards --}}
        @php
            $cards = [
                ['title' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'), 'icon' => 'bi-wallet2', 'color' => 'success'],
                ['title' => 'Perlu Diproses', 'value' => $stats['pending_orders'], 'icon' => 'bi-box-seam', 'color' => 'warning'],
                ['title' => 'Stok Menipis', 'value' => $stats['low_stock'], 'icon' => 'bi-exclamation-triangle', 'color' => 'danger'],
                ['title' => 'Total Produk', 'value' => $stats['total_products'], 'icon' => 'bi-tags', 'color' => 'primary'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm border-start border-4 border-{{ $card['color'] }} h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.75rem">{{ $card['title'] }}</p>
                            <h4 class="fw-bold mb-0 text-{{ $card['color'] }}">{{ $card['value'] }}</h4>
                        </div>
                        <div class="bg-{{ $card['color'] }} bg-opacity-10 p-3 rounded-circle">
                            <i class="bi {{ $card['icon'] }} text-{{ $card['color'] }} fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        {{-- Grafik Penjualan --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow me-2 text-success"></i>Tren Penjualan (7 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pesanan Terbaru --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0">Pesanan Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentOrders as $order)
                        <div class="list-group-item border-0 px-4 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-dark">#{{ $order->order_number }}</div>
                                    <small class="text-muted">{{ Str::limit($order->user->name, 15) }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="small fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
                                    <span class="badge rounded-pill shadow-sm" style="font-size: 0.7rem; background-color: {{ $order->payment_status == 'paid' ? '#d1e7dd' : '#f8d7da' }}; color: {{ $order->payment_status == 'paid' ? '#0f5132' : '#842029' }};">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center py-3">
                    <a href="{{ route('admin.orders.index') }}" class="small text-success fw-bold text-decoration-none">
                        KELOLA SEMUA PESANAN <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Produk Terlaris --}}
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white border-0 py-3">
            <h6 class="fw-bold mb-0">Produk Terlaris</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($topProducts as $product)
                <div class="col-4 col-md-2 text-center">
                    <div class="p-2 rounded hover-scale">
                        <img src="{{ $product->image_url }}" class="rounded shadow-sm mb-2" style="width: 100%; height: 80px; object-fit: cover;">
                        <div class="small fw-bold text-truncate">{{ $product->name }}</div>
                        <div class="badge bg-light text-dark border fw-normal" style="font-size: 0.7rem">{{ $product->sold }} Terjual</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Script Chart.js dengan Warna Hijau --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Gradient effect untuk grafik
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(25, 135, 84, 0.3)');
        gradient.addColorStop(1, 'rgba(25, 135, 84, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueChart->pluck('date')) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($revenueChart->pluck('total')) !!},
                    borderColor: '#198754', // Hijau Sukses
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#198754',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#f0f0f0' },
                        ticks: {
                            callback: value => 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(value)
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
@endsection
