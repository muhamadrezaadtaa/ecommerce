<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user')
            ->when($request->status, function($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order untuk admin.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan dengan Restock Otomatis.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1. Validasi Input
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Jika status tidak berubah, langsung kembali
        if ($oldStatus === $newStatus) {
            return back()->with('info', "Status sudah bernilai " . ucfirst($newStatus));
        }

        try {
            DB::beginTransaction();

            // 2. Logika RESTOCK: Jika dibatalkan (tambah stok)
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            }

            // 3. Logika RE-ORDER: Jika dari 'cancelled' ke status aktif (kurangi stok)
            if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        // Opsional: Cek apakah stok cukup sebelum dikurangi kembali
                        if ($item->product->stock < $item->quantity) {
                            throw new \Exception("Gagal mengubah status. Stok produk '{$item->product->name}' tidak mencukupi.");
                        }
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            }

            // 4. Update Database Menggunakan Update atau Force Fill
            // Menggunakan fill() dan save() sering lebih aman untuk debugging
            $order->status = $newStatus;
            $order->save();

            DB::commit();
            
            return back()->with('success', "Status pesanan #{$order->order_number} berhasil diperbarui ke " . ucfirst($newStatus));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal update status Order ID {$order->id}: " . $e->getMessage());
            
            return back()->with('error', $e->getMessage());
        }
    }
}