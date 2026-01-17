{{-- ================================================
     FILE: resources/views/partials/navbar.blade.php
     ================================================ --}}

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        {{-- Logo & Brand --}}
        <a class="navbar-brand d-flex align-items-center fw-bold text-success" href="{{ route('home') }}">
            <i class="bi bi-leaf-fill me-2"></i>
            <span style="letter-spacing: -0.5px;">Toko Tanaman Hias</span>
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Form --}}
            <form class="d-flex mx-auto mt-3 mt-lg-0" style="max-width: 400px; width: 100%;" action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group overflow-hidden rounded-pill border">
                    <input type="text" name="q" class="form-control border-0 ps-4" placeholder="Cari tanaman favoritmu..." value="{{ request('q') }}">
                    <button class="btn btn-white border-0 text-success px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="{{ route('catalog.index') }}">
                        <i class="bi bi-grid fs-5"></i> Katalog
                    </a>
                </li>

                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link position-relative px-2" href="{{ route('wishlist.index') }}">
                            <i class="bi bi-heart fs-5"></i>
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger border border-white" style="font-size: 0.5rem; padding: 0.35em 0.5em;">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Cart --}}
                    <li class="nav-item me-2">
                        <a class="nav-link position-relative px-2" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-success border border-white" style="font-size: 0.5rem; padding: 0.35em 0.5em;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User Profile --}}
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center bg-light rounded-pill px-3 py-1" href="#" id="userDropdown" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle me-2" width="28" height="28" alt="User">
                            <span class="small fw-bold">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('orders.index') }}"><i class="bi bi-bag me-2"></i> Pesanan</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-primary py-2" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard Admin</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link px-3" href="{{ route('login') }}">Masuk</a></li>
                    <li class="nav-item"><a class="btn btn-success rounded-pill px-4 shadow-sm btn-sm" href="{{ route('register') }}">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>