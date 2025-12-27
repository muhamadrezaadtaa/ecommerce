@extends('layouts.app')

@section('content')
    <div class="container py-5 text-center">
        <h1 class="text-success display-4">Pembayaran Berhasil! 🤪🤘</h1>
        <p class="lead">Pesanan #{{ $order->order_number }} telah dibayar.</p>
        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-lg">Lihat Detail Pesanan</a>
    </div>
@endsection