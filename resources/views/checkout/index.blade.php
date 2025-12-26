{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="display-5 fw-bold mb-4">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="row g-5">
                {{-- Form Alamat - Kiri --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h5 fw-semibold mb-4">Informasi Pengiriman</h2>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label">Nama Penerima</label>
                                    <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
                                           class="form-control" required>
                                </div>

                                <div class="col-12">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" name="phone" id="phone" class="form-control" required>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label">Alamat Lengkap</label>
                                    <textarea name="address" id="address" rows="4" class="form-control" required></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <div class="form-check border rounded p-3">
                                        <input class="form-check-input" type="radio" name="payment" id="transfer" value="transfer" checked>
                                        <label class="form-check-label fw-medium" for="transfer">
                                            Transfer Bank (Verifikasi Manual)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan Pesanan - Kanan --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm sticky-lg-top" style="top: 1.5rem;">
                        <div class="card-body p-4">
                            <h2 class="h5 fw-semibold mb-4">Ringkasan Pesanan</h2>

                            <div class="overflow-auto mb-4" style="max-height: 300px;">
                                @forelse($cart->items as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="text-muted small flex-grow-1 pe-3">
                                            {{ $item->product->name }}<br>
                                            <span class="text-secondary">× {{ $item->quantity }}</span>
                                        </div>
                                        <div class="fw-bold text-nowrap">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted text-center mb-0">Keranjang kosong</p>
                                @endforelse
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold fs-5">Total</span>
                                <span class="fw-bold text-primary fs-4 text-nowrap">
                                    Rp {{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 0, ',', '.') }}
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                                Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection