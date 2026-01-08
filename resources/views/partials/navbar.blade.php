{{-- ================================================
FILE: resources/views/partials/navbar.blade.php
FUNGSI: Navigation bar untuk customer (Tema Abu-abu & Orange)
================================================ --}}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top" style="border-bottom: 3px solid #fd7e14;">
    <div class="container">
        {{-- Logo & Brand --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-bag-heart-fill me-2" style="color: #fd7e14;"></i>
            Vortex <span style="color: #fd7e14;">Wear</span>
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Form --}}
            <form class="d-flex mx-auto" style="max-width: 400px; width: 100%;" action="{{ route('catalog.index') }}"
                method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control border-secondary bg-dark text-white shadow-none" 
                           placeholder="Cari produk..." value="{{ request('q') }}" style="border-radius: 5px 0 0 5px;">
                    <button class="btn" type="submit" style="background-color: #fd7e14; color: white;">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-center">
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link text-light hover-orange" href="{{ route('catalog.index') }}">
                        <i class="bi bi-grid me-1"></i> Katalog
                    </a>
                </li>

                @auth
                {{-- Wishlist --}}
                <li class="nav-item">
                    <a class="nav-link position-relative text-light" href="{{ route('wishlist.index') }}">
                        <i class="bi bi-heart"></i>
                        @if(auth()->user()->wishlists()->count() > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                            style="font-size: 0.6rem; background-color: #fd7e14;">
                            {{ auth()->user()->wishlists()->count() }}
                        </span>
                        @endif
                    </a>
                </li>

                {{-- Cart --}}
                <li class="nav-item">
                    <a class="nav-link position-relative text-light" href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3"></i>
                        @php
                        $cartCount = auth()->user()->cart?->items()->count() ?? 0;
                        @endphp
                        @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-dark"
                            style="font-size: 0.6rem; border: 1px solid #fd7e14;">
                            {{ $cartCount }}
                        </span>
                        @endif
                    </a>
                </li>

                {{-- User Dropdown --}}
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-light" href="#" id="userDropdown"
                        data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle me-2 border" 
                            style="border-color: #fd7e14 !important;" width="32" height="32"
                            alt="{{ auth()->user()->name }}">
                        <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('orders.index') }}">
                                <i class="bi bi-bag me-2"></i> Pesanan Saya
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item fw-bold" style="color: #fd7e14;" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                            </a>
                        </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                {{-- Guest Links --}}
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('login') }}">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-sm ms-2 px-3 fw-bold" href="{{ route('register') }}" 
                       style="background-color: #fd7e14; color: white; border: none;">
                        Daftar
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .hover-orange:hover {
        color: #fd7e14 !important;
        transition: 0.3s;
    }
</style>