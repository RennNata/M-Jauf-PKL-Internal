<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     * Dilengkapi filter by status.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user') // N+1 prevention: Load data user pemilik order
            // Fitur Filter Status (?status=pending)
            ->when($request->status, function($q, $status) {
                $q->where('status', $status);
            })
            ->latest() // Urutkan terbaru
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order untuk admin.
     */
    public function show(Order $order)
    {
        // Load item produk dan data user
        $order->load(['user', 'items.product.primaryImage']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan (misal: kirim barang)
     * Handle otomatis pengembalian stok jika status diubah jadi Cancelled.
     */
    public function updateStatus(Request $request, Order $order)
{
    // 1. Tambahkan 'shipped' dan 'delivered' di validasi
    // 2. Kita pakai 'delivered' sebagai pengganti 'completed' agar sinkron dengan UI
    $request->validate([
        'status' => 'required|in:processing,shipped,completed,cancelled'
    ]);

    $oldStatus = $order->status;
    $newStatus = $request->status;

    // LOGIKA RESTOCK (Tetap dipertahankan karena ini keren buat nilai plus)
    if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }
    }

    // Update status di database
    $order->update(['status' => $newStatus]);

    // Logika Otomatis: Jika sudah Delivered, set Payment jadi Paid (Opsional tapi logis)
    if ($newStatus === 'delivered') {
        $order->update(['payment_status' => 'paid']);
    }

    return back()->with('success', "Status pesanan berhasil diupdate menjadi: " . strtoupper($newStatus));
}
}