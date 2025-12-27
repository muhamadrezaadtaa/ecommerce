{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="display-5 fw-bold mb-5 text-center">Checkout</h1>

                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <div class="row g-5">
                        {{-- Form Alamat & Pembayaran - Kiri (lebih lebar di mobile) --}}
                        <div class="col-lg-7 order-lg-first">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body p-4 p-md-5">
                                    <h2 class="h4 fw-bold mb-4">Informasi Pengiriman</h2>

                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label for="name" class="form-label fw-medium">Nama Penerima <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                                   class="form-control form-control-lg" required>
                                        </div>

                                        <div class="col-12">
                                            <label for="phone" class="form-label fw-medium">Nomor Telepon <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                                   class="form-control form-control-lg" placeholder="08xxxxxxxxxx" required>
                                        </div>

                                        <div class="col-12">
                                            <label for="address" class="form-label fw-medium">Alamat Lengkap <span class="text-danger">*</span></label>
                                            <textarea name="address" id="address" rows="5" class="form-control form-control-lg"
                                                      placeholder="Jalan, nomor rumah, rt/rw, kelurahan, kecamatan, kota/kabupaten, provinsi" required>{{ old('address') }}</textarea>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <h2 class="h5 fw-bold mb-4">Metode Pembayaran</h2>
                                            <div class="border rounded-4 p-4 bg-light">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment" id="transfer" value="transfer" checked>
                                                    <label class="form-check-label fw-semibold fs-5" for="transfer">
                                                        Transfer Bank (Verifikasi Manual)
                                                    </label>
                                                    <p class="text-muted small mt-2 mb-0">
                                                        Pembayaran melalui transfer bank akan diverifikasi secara manual dalam 1×24 jam.
                                                    </p>
                                                </div>
                                                {{-- Jika ada metode lain di masa depan, tambahkan di sini --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Ringkasan Pesanan - Kanan (sticky & muncul atas di mobile) --}}
                        <div class="col-lg-5 order-lg-last">
                            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 1.5rem;">
                                <div class="card-body p-4 p-md-5">
                                    <h2 class="h4 fw-bold mb-4">Ringkasan Pesanan</h2>

                                    <div class="overflow-auto mb-4" style="max-height: 350px;">
                                        @forelse($cart->items as $item)
                                            <div class="d-flex mb-4 pb-4 border-bottom">
                                                <div class="flex-shrink-0 me-4">
                                                    {{-- Jika ada gambar produk, tambahkan: <img src="{{ $item->product->image }}" class="rounded" width="80" alt="{{ $item->product->name }}"> --}}
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                        <small class="text-muted">No Image</small>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-semibold">{{ $item->product->name }}</h6>
                                                    <p class="text-muted small mb-0">× {{ $item->quantity }}</p>
                                                </div>
                                                <div class="text-end fw-bold">
                                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted text-center py-5 mb-0">Keranjang kosong</p>
                                        @endforelse
                                    </div>

                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <span class="h5 fw-bold mb-0">Total</span>
                                        <span class="h4 fw-bold text-primary mb-0">
                                            Rp {{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-4 shadow">
                                        Buat Pesanan
                                    </button>

                                    <p class="text-muted small text-center mt-3 mb-0">
                                        Dengan melanjutkan, Anda menyetujui syarat & ketentuan kami.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection