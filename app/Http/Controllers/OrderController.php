<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\MidtransService;

class OrderController extends Controller
{
    public function show(Order $order, MidtransService $midtrans)
    {
        $order->load(['items', 'user']);

        $snapToken = null;
        if ($order->status == 'pending') {
            $snapToken = $midtrans->createSnapToken($order);
        }

        return view('orders.show', compact('order', 'snapToken'));
    }
    // app/Http/Controllers/OrderController.php (atau PaymentController.php)

    public function success(Order $order)
    {
        // Optional: cek status terbaru dari Midtrans kalau mau lebih aman
        // Tapi cukup tampilkan pesan sukses aja untuk UX
        return view('orders.success', compact('order'));
    }

    public function pending(Order $order)
    {
        return view('orders.pending', compact('order'));
    }
}