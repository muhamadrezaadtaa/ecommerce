<?php
// app/Services/OrderService.php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Membuat Order baru dari Keranjang belanja.
     * * Sinkronisasi Status:
     * - Order: 'pending' (Menunggu pembayaran)
     * - Payment: 'unpaid' (Belum dibayar)
     */
    public function createOrder(User $user, array $shippingData): Order
    {
        // 1. Ambil Keranjang User dengan Eager Loading untuk performa
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong.");
        }

        // ==================== DATABASE TRANSACTION START ====================
        return DB::transaction(function () use ($user, $cart, $shippingData) {

            // A. VALIDASI STOK & HITUNG TOTAL
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }
                
                // Gunakan harga display (mendukung diskon jika ada)
                $price = $item->product->discount_price > 0 && $item->product->discount_price < $item->product->price 
                         ? $item->product->discount_price 
                         : $item->product->price;

                $totalAmount += $price * $item->quantity;
            }

            // B. BUAT HEADER ORDER
            // Format order_number ORD-RANDOM ini yang ditangkap MidtransNotificationController
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'ORD-' . strtoupper(Str::random(10)),
                'status'           => 'pending', 
                'payment_status'   => 'unpaid', // Diupdate jadi 'paid' oleh Notification Controller
                'shipping_name'    => $shippingData['name'],
                'shipping_address' => $shippingData['address'],
                'shipping_phone'   => $shippingData['phone'],
                'total_amount'     => $totalAmount,
            ]);

            // C. PINDAHKAN ITEMS & KURANGI STOK
            foreach ($cart->items as $item) {
                $currentPrice = $item->product->discount_price > 0 && $item->product->discount_price < $item->product->price 
                                ? $item->product->discount_price 
                                : $item->product->price;

                $order->items()->create([
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name, // Snapshot
                    'price'        => $currentPrice,        // Snapshot
                    'quantity'     => $item->quantity,
                    'subtotal'     => $currentPrice * $item->quantity,
                ]);

                // Update stok secara atomik
                $item->product->decrement('stock', $item->quantity);
            }

            // D. BERSIHKAN KERANJANG
            $cart->items()->delete();

            return $order;
        });
        // ==================== DATABASE TRANSACTION END ====================
    }
}