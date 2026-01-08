<?php
// app/Http/Controllers/MidtransNotificationController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\OrderPaidEvent;

class MidtransNotificationController extends Controller
{
    /**
     * Handle incoming webhook notification from Midtrans.
     * URL: POST /midtrans/notification
     */
    /**
     * Handle incoming webhook notification from Midtrans.
     * URL: POST /midtrans/notification
     * Access: Public (Midtrans Server)
     */
    public function handle(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Notification Received', $payload);

        $rawOrderId        = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $serverKey         = config('midtrans.server_key');

        // 1. Validasi Signature
        $expectedSignature = hash("sha512", $rawOrderId . $statusCode . $grossAmount . $serverKey);
        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans Notification: Invalid signature', ['order_id' => $rawOrderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Pecah Order ID (Mengambil bagian ORD-xxxx saja)
        // Jika ID: ORD-123-170462000 -> explode akan mengambil ORD-123
        $parts = explode('-', $rawOrderId);
        $orderNumber = $parts[0] . '-' . $parts[1];

        // 3. Cari Order
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            Log::error('Midtrans Notification: Order Not Found', ['order_number' => $orderNumber]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 4. Idempotency (Jangan proses jika sudah Paid)
        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Already paid'], 200);
        }

        // 5. Update Status
        try {
            DB::transaction(function () use ($order, $transactionStatus, $payload) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status'         => 'processing'
                    ]);

                    if ($order->payment) {
                        $order->payment->update([
                            'status' => 'success',
                            'paid_at' => now(),
                            'midtrans_transaction_id' => $payload['transaction_id'] ?? null
                        ]);
                    }

                    // Trigger Event jika ada
                    event(new OrderPaidEvent($order));

                } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $order->update([
                        'payment_status' => 'failed',
                        'status'         => 'cancelled'
                    ]);
                    
                    // Balikin Stok
                    foreach ($order->items as $item) {
                        $item->product?->increment('stock', $item->quantity);
                    }
                }
            });

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Update Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * Handle pembayaran sukses.
     */
    protected function handleSuccess(Order $order, ?Payment $payment): void
    {
        Log::info("Payment SUCCESS for Order: {$order->order_number}");

        // Update Order
        $order->update([
            'status' => 'processing', // Siap diproses/dikirim
            'payment_status' => 'paid', // Tandai sudah dibayar
        ]);

        // Update Payment
        if ($payment) {
            $payment->update([
                'status'  => 'success',
                'paid_at' => now(),
            ]);
        }

        // TODO: Kirim email konfirmasi pembayaran
        // event(new PaymentSuccessful($order));
    }

    /**
     * Handle pembayaran pending.
     */
    protected function handlePending(Order $order, ?Payment $payment, string $message = ''): void
    {
        Log::info("Payment PENDING for Order: {$order->order_number}", ['message' => $message]);

        // Order tetap pending
        // Payment tetap pending
        if ($payment) {
            $payment->update(['status' => 'pending']);
        }
    }

    /**
     * Handle pembayaran gagal/expired/cancelled.
     */
    protected function handleFailed(Order $order, ?Payment $payment, string $reason = ''): void
    {
        Log::info("Payment FAILED for Order: {$order->order_number}", ['reason' => $reason]);

        // Update Order
        $order->update([
            'status' => 'cancelled',
        ]);

        // Update Payment
        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        // ============================================================
        // RESTOCK LOGIC (Kembalikan stok produk)
        // ============================================================
        foreach ($order->items as $item) {
            $item->product?->increment('stock', $item->quantity);
        }

        // TODO: Kirim email notifikasi pembayaran gagal
    }

    /**
     * Handle refund.
     */
    protected function handleRefund(Order $order, ?Payment $payment): void
    {
        Log::info("Payment REFUNDED for Order: {$order->order_number}");

        if ($payment) {
            $payment->update(['status' => 'refunded']);
        }

        // TODO: Logic tambahan untuk refund
    }
    private function setSuccess(Order $order)
{
    $order->update([]);

    // Fire & Forget
    event(new OrderPaidEvent($order));
}
}