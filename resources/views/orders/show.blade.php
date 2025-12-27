{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">

            {{-- Breadcrumb / Header --}}
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Detail Pesanan</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                {{-- Header Order --}}
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold">Order #{{ $order->order_number }}</h4>
                            <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>

                        {{-- Status Badge Bootstrap --}}
                        @php
                            $statusClasses = [
                                'pending'    => 'bg-warning text-dark',
                                'processing' => 'bg-primary',
                                'shipped'    => 'bg-info text-white',
                                'delivered'  => 'bg-success',
                                'cancelled'  => 'bg-danger',
                            ];
                            $badgeClass = $statusClasses[$order->status] ?? 'bg-secondary';
                        @endphp
                        <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Produk yang Dipesan</h5>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                @if($order->shipping_cost > 0)
                                <tr>
                                    <td colspan="3" class="text-end pt-3">Ongkos Kirim:</td>
                                    <td class="text-end pt-3">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5">TOTAL BAYAR:</td>
                                    <td class="text-end fw-bold fs-5 text-primary">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="card-footer bg-light p-4 border-top-0">
                    <h5 class="fw-bold mb-3">Alamat Pengiriman</h5>
                    <div class="text-dark">
                        <p class="mb-1 fw-bold">{{ $order->shipping_name }}</p>
                        <p class="mb-1 text-muted">{{ $order->shipping_phone }}</p>
                        <p class="mb-0">{{ $order->shipping_address }}</p>
                    </div>
                </div>

                {{-- Tombol Bayar --}}
                @if($order->status === 'pending' && isset($snapToken))
                <div class="card-body p-4 bg-primary bg-opacity-10 border-top text-center">
                    <p class="text-muted mb-3">Selesaikan pembayaran Anda sekarang.</p>
                    <button id="pay-button" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm">
                        💳 Bayar Sekarang
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if(isset($snapToken))
        {{-- Load Snap JS --}}
        <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');

                if (payButton) {
                    payButton.addEventListener('click', function() {
                        payButton.disabled = true;
                        payButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

                        window.snap.pay('{{ $snapToken }}', {
                            onSuccess: function(result) {
                                window.location.href = '{{ route("orders.success", $order) }}';
                            },
                            onPending: function(result) {
                                window.location.href = '{{ route("orders.pending", $order) }}';
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal!');
                                payButton.disabled = false;
                                payButton.innerHTML = '💳 Bayar Sekarang';
                            },
                            onClose: function() {
                                payButton.disabled = false;
                                payButton.innerHTML = '💳 Bayar Sekarang';
                            }
                        });
                    });
                }
            });
        </script>
    @endif
@endpush