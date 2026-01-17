<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- Tambahkan Bootstrap Icons jika belum ada di app.js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        
        /* Sidebar dengan tema Hijau Gelap (Dark Forest) */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #143621 0%, #0a1a10 100%);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.65);
            padding: 12px 20px;
            border-radius: 10px;
            margin: 4px 15px;
            transition: all 0.2s ease-in-out;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i { font-size: 1.1rem; width: 28px; }

        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: #28a745; /* Hijau sesuai tema */
            color: #fff;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.25);
        }

        .brand-section {
            padding: 25px 20px;
            background: rgba(0,0,0,0.1);
        }

        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #edf2f7;
            padding: 0.75rem 1.5rem;
        }

        .main-content {
            background-color: #f8fafc;
            min-height: 100vh;
        }

        /* Custom Scrollbar untuk Sidebar */
        .sidebar::-webkit-scrollbar { width: 5px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        {{-- Sidebar --}}
        <div class="sidebar d-flex flex-column shadow" style="width: 260px; position: sticky; top: 0;">
            {{-- Brand --}}
            <div class="brand-section mb-3 text-center">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-decoration-none">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="bi bi-leaf-fill fs-3 text-success me-2"></i>
                        <span class="fs-5 fw-bold tracking-tight">ADMIN<span class="text-success">PLANT</span></span>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-grow-1">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item mt-3 px-4 mb-2">
                        <span class="text-uppercase small fw-bold" style="color: rgba(255,255,255,0.3); font-size: 0.7rem; letter-spacing: 1px;">Manajemen</span>
                    </li>

                    <li class="nav-item text">
                        <a href="{{ route('admin.products.index') }}"
                           class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <i class="bi bi-flower1"></i> Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}"
                           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <i class="bi bi-tags"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}"
                           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <i class="bi bi-cart-check"></i> Pesanan
                            @php
                                // Saran: Pindahkan logic ini ke View Composer nanti
                                $pendingCount = \App\Models\Order::where('status', 'processing')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge rounded-pill bg-danger ms-auto" style="font-size: 0.7rem">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Pengguna
                        </a>
                    </li>

                    <li class="nav-item mt-3 px-4 mb-2">
                        <span class="text-uppercase small fw-bold" style="color: rgba(255,255,255,0.3); font-size: 0.7rem; letter-spacing: 1px;">Insight</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.reports.sales') }}"
                           class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                            <i class="bi bi-bar-chart-line"></i> Laporan
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- User Info --}}
            <div class="p-3 bg-black bg-opacity-25 mt-auto">
                <div class="d-flex align-items-center">
                    <img src="{{ auth()->user()->avatar_url }}"
                         class="rounded-circle border border-2 border-success me-2" width="35" height="35" style="object-fit: cover;">
                    <div class="overflow-hidden">
                        <div class="small fw-bold text-white text-truncate">{{ auth()->user()->name }}</div>
                        <div class="text-success" style="font-size: 0.7rem;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> Online</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="flex-grow-1 main-content">
            {{-- Top Bar --}}
            <header class="topbar sticky-top d-flex justify-content-between align-items-center shadow-sm">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">@yield('page-title', 'Dashboard Overview')</h5>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('home') }}" class="btn btn-light border btn-sm rounded-pill px-3" target="_blank">
                        <i class="bi bi-eye me-1"></i> Preview Toko
                    </a>
                    <div class="vr mx-2 text-muted" style="height: 20px;"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                            <i class="bi bi-power"></i> Keluar
                        </button>
                    </form>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-4 pt-4">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <main class="p-4 pt-2">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>