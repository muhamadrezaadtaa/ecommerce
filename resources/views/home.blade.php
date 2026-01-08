{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama website dengan Tema Abu-abu & Orange
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section - Abu-abu Gelap dengan Aksen Orange --}}
    <section class="text-white py-5" style="background-color: #212529; border-bottom: 5px solid #fd7e14;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">
                        Transaksi Aman, <span style="color: #fd7e14;">Barang Nyata.</span>
                    </h1>
                    <p class="lead mb-4" style="color: #adb5bd;">
                        Bukan sekadar kaos, tapi identitas. Amankan desainmu sebelum jadi milik orang lain!
                    </p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-lg px-4 fw-bold" 
                       style="background-color: #fd7e14; color: white; border: none;">
                        <i class="bi bi-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('images/abin.png') }}"
                         alt="Shopping" class="img-fluid" style="max-height: 400px; filter: drop-shadow(0 0 10px rgba(253, 126, 20, 0.3));">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori - Background Abu-abu Sangat Muda --}}
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold text-uppercase" style="color: #343a40;">
                Kategori <span style="color: #fd7e14;">Populer</span>
            </h2>
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                           class="text-decoration-none category-card">
                            <div class="card border-0 shadow-sm text-center h-100 transition-hover">
                                <div class="card-body">
                                    <img src="{{ $category->image_url }}"
                                         alt="{{ $category->name }}"
                                         class="rounded-circle mb-3"
                                         width="80" height="80"
                                         style="object-fit: cover; border: 3px solid #fd7e14;">
                                    <h6 class="card-title mb-0 fw-bold text-dark">{{ $category->name }}</h6>
                                    <small class="text-muted">{{ $category->products_count }} produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Produk Unggulan - Background Abu-abu Medium --}}
    <section class="py-5" style="background-color: #e9ecef;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 border-start border-4 border-warning ps-3" style="border-color: #fd7e14 !important;">
                <h2 class="fw-bold mb-0" style="color: #343a40;">PRODUK UNGGULAN</h2>
                <a href="{{ route('catalog.index') }}" class="btn btn-sm fw-bold" style="color: #fd7e14; border: 1px solid #fd7e14;">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Promo Banner - Kontras Orange & Gelap --}}
    <section class="py-5" style="background-color: #ffffff;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 text-white shadow overflow-hidden" style="min-height: 200px; background-color: #fd7e14;">
                        <div class="card-body d-flex flex-column justify-content-center p-4 position-relative">
                            <div style="z-index: 1;">
                                <h3 class="fw-bold">Flash Sale!</h3>
                                <p>Diskon hingga 50% untuk produk pilihan tanpa kompromi.</p>
                                <a href="#" class="btn btn-dark fw-bold shadow-sm">Lihat Promo</a>
                            </div>
                            <i class="bi bi-lightning-fill position-absolute end-0 bottom-0 opacity-25" style="font-size: 8rem; margin-right: -20px; margin-bottom: -20px;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 text-white shadow" style="min-height: 200px; background-color: #343a40; border-left: 5px solid #fd7e14 !important;">
                        <div class="card-body d-flex flex-column justify-content-center p-4">
                            <h3 class="fw-bold">Member <span style="color: #fd7e14;">Baru?</span></h3>
                            <p>Dapatkan voucher Rp 50.000 untuk pembelian pertama.</p>
                            <a href="{{ route('register') }}" class="btn btn-outline-light fw-bold" style="width: fit-content;">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Terbaru --}}
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold" style="color: #343a40;">PRODUK <span style="color: #fd7e14;">TERBARU</span></h2>
            <div class="row g-4">
                @foreach($latestProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .category-card:hover .card {
            background-color: #fff3e6 !important;
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
@endsection