<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik user yang sedang login.
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.product']) 
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan dan menangani Snap Token Midtrans.
     */
    public function show(Order $order)
    {
        // 1. Security Check: Pastikan user hanya bisa melihat pesanannya sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // 2. Normalisasi status ke lowercase untuk menghindari typo (Pending vs pending)
        $status = strtolower($order->status);
        $snapToken = $order->snap_token;

        // 3. Logika Midtrans (Hanya jika pesanan masih pending)
        if ($status === 'pending') {
            
            // Konfigurasi Midtrans diambil dari config/midtrans.php atau .env
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Jika belum ada snap_token di database, kita buatkan baru
            if (!$snapToken) {
                try {
                    $params = [
                        'transaction_details' => [
                            'order_id' => $order->order_number . '-' . time(), // Tambah suffix time agar order_id selalu unik jika ada kegagalan sebelumnya
                            'gross_amount' => (int) $order->total_amount,
                        ],
                        'customer_details' => [
                            'first_name' => auth()->user()->name,
                            'email' => auth()->user()->email,
                            'phone' => $order->shipping_phone,
                        ],
                        'item_details' => $order->items->map(function ($item) {
                            return [
                                'id' => $item->product_id,
                                'price' => (int) $item->price,
                                'quantity' => $item->quantity,
                                'name' => substr($item->product_name, 0, 50), // Midtrans max 50 karakter
                            ];
                        })->toArray(),
                    ];

                    $snapToken = Snap::getSnapToken($params);

                    // Simpan ke database agar tidak request terus menerus
                    $order->update(['snap_token' => $snapToken]);
                    
                } catch (\Exception $e) {
                    Log::error('Midtrans Error for Order #' . $order->order_number . ': ' . $e->getMessage());
                    // Kita biarkan snapToken null, nanti di view akan muncul pesan error
                }
            }
        }

        // 4. Load data relasi untuk kebutuhan View
        $order->load(['items.product']);

        return view('orders.show', compact('order', 'snapToken'));
    }
}