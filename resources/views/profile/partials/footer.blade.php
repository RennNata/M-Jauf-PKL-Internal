<footer class="bg-dark text-light pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            {{-- Brand & Description --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="text-success mb-3 fw-bold">
                    <i class="bi bi-leaf-fill me-2"></i>Toko Tanaman Hias
                </h5>
                <p class="text-secondary lh-lg">
                    Membawa kesegaran alam ke dalam hunian Anda. Kami menyediakan berbagai koleksi tanaman hias kualitas terbaik dengan perawatan yang terjamin.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="https://www.instagram.com/usepusepkepala" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-instagram"></i></a>
                    <a href="https://github.com/RennNata" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-github"></i></a>
                    <a href="https://wa.me/628815129216" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-4 fw-bold">Belanja</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="{{ route('catalog.index') }}" class="text-secondary text-decoration-none hover-success">Katalog Produk</a></li>
                    <li class="mb-3"><a href="#" class="text-secondary text-decoration-none">Promo Spesial</a></li>
                </ul>
            </div>

            {{-- Help --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="text-white mb-4 fw-bold">Bantuan</h6>
                <ul class="list-unstyled">
                    <li class="mb-3"><a href="#" class="text-secondary text-decoration-none">Cara Perawatan</a></li>
                    
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-lg-4 col-md-6">
                <h6 class="text-white mb-4 fw-bold">Hubungi Kami</h6>
                <ul class="list-unstyled text-secondary">
                    <li class="d-flex mb-3">
                        <i class="bi bi-geo-alt text-success me-3"></i>
                        <span>Jl. Taman Cibaduyut Indah Blok G. 28, Bandung, Jawa Barat</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-telephone text-success me-3"></i>
                        <span>+62 881-5129-216</span>
                    </li>
                    <li class="d-flex mb-3">
                        <i class="bi bi-envelope text-success me-3"></i>
                        <span>admin@tokotanamanhias.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-secondary mb-0 small">
                    &copy; {{ date('Y') }} <strong>Toko Tanaman Hias</strong>. Dibuat dengan <i class="bi bi-heart-fill text-danger"></i> untuk pecinta tanaman.
                </p>
            </div>
            
        </div>
    </div>
</footer>