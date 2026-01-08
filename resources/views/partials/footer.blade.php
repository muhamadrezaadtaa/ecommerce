{{-- ================================================
FILE: resources/views/partials/footer.blade.php
FUNGSI: Footer website (Tema Abu-abu & Orange)
================================================ --}}

<footer class="text-light pt-5 pb-3 mt-5" style="background-color: #1a1d20; border-top: 4px solid #fd7e14;">
    <div class="container">
        <div class="row g-4">
            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white mb-3 fw-bold">
                    <i class="bi bi-bag-heart-fill me-2" style="color: #fd7e14;"></i>Vortex <span style="color: #fd7e14;">Wear</span>
                </h5>
                <p style="color: #adb5bd;">
                    Bukan sekadar kaos, tapi identitas. Kami menyediakan produk distro berkualitas tinggi dengan desain eksklusif untuk gaya hidup modern Anda.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-3 fw-bold uppercase-tracking">Menu</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('catalog.index') }}" class="footer-link">Katalog Produk</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Tentang Kami</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Kontak</a>
                    </li>
                </ul>
            </div>

            {{-- Help --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-3 fw-bold uppercase-tracking">Bantuan</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="footer-link">FAQ</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Cara Belanja</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="footer-link">Kebijakan Privasi</a>
                    </li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="text-white mb-3 fw-bold uppercase-tracking">Hubungi Kami</h6>
                <ul class="list-unstyled" style="color: #adb5bd;">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt me-2" style="color: #fd7e14;"></i>
                        <span>Jl. Cisirung No. 123, Bandung, Jawa Barat</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone me-2" style="color: #fd7e14;"></i>
                        <span>(022) 123-4567</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope me-2" style="color: #fd7e14;"></i>
                        <span>support@vortexwear.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 small" style="color: #6c757d;">
                    &copy; {{ date('Y') }} <span class="fw-bold">Vortex Wear</span>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                {{-- Placeholder untuk icon pembayaran, jika tidak ada gambar bisa menggunakan teks/icon --}}
                <div class="text-secondary small">
                    <i class="bi bi-credit-card-2-back me-2"></i> Pembayaran Aman & Terverifikasi
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-link {
        color: #adb5bd;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .footer-link:hover {
        color: #fd7e14;
        padding-left: 5px;
    }
    .social-icon {
        color: #adb5bd;
        font-size: 1.2rem;
        transition: 0.3s;
    }
    .social-icon:hover {
        color: #fd7e14;
        transform: translateY(-3px);
    }
    .uppercase-tracking {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }
</style>