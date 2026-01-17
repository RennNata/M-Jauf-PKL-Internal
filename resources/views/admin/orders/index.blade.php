@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="h3 mb-0 text-gray-800 fw-bold">Daftar Pesanan</h2>
        <p class="text-muted">Kelola transaksi dan status pengiriman pelanggan.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 border-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            {{-- Filter Status --}}
            <ul class="nav nav-pills card-header-pills bg-light p-1 rounded">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active bg-success shadow-sm' : 'text-muted' }}" href="{{ route('admin.orders.index') }}">Semua</a>
                </li>
                @foreach(['pending' => 'Pending', 'processing' => 'Diproses', 'completed' => 'Selesai', 'cancelled' => 'Batal'] as $val => $label)
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == $val ? 'active bg-success shadow-sm' : 'text-muted' }}" 
                       href="{{ route('admin.orders.index', ['status' => $val]) }}">{{ $label }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4 py-3">INVOICE</th>
                        <th>CUSTOMER</th>
                        <th>TANGGAL</th>
                        <th>TOTAL PEMBAYARAN</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-end pe-4">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                                        <small class="text-muted">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}<br><small class="text-muted">{{ $order->created_at->format('H:i') }} WIB</small></td>
                            <td>
                                <span class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-warning-subtle text-warning-emphasis border-warning',
                                        'processing' => 'bg-info-subtle text-info-emphasis border-info',
                                        'completed' => 'bg-success-subtle text-success-emphasis border-success',
                                        'cancelled' => 'bg-danger-subtle text-danger-emphasis border-danger',
                                        'shipped' => 'bg-primary-subtle text-primary-emphasis border-primary'
                                    ];
                                    $color = $statusColors[$order->status] ?? 'bg-secondary-subtle';
                                @endphp
                                <span class="badge {{ $color }} border px-3 py-2 text-uppercase" style="font-size: 0.7rem;">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-white border shadow-sm px-3">
                                    <i class="bi bi-eye me-1 text-primary"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/empty-folder.svg" style="width: 150px;" class="mb-3 opacity-50">
                                <p class="text-muted">Tidak ada pesanan yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection