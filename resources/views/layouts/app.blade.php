{{-- ================================================
     FILE: resources/views/layouts/app.blade.php
     FUNGSI: Master layout untuk halaman customer/publik
     ================================================ --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSRF Token untuk AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Stack untuk CSS tambahan per halaman --}}
    @stack('styles')

    {{-- Stack untuk script tambahan dari child view --}}
    @stack('scripts')
</head>
<body>
  @unless(request()->routeIs('login', 'register', 'password.*', 'verification.*'))
    {{-- ============================================
         NAVBAR
         ============================================ --}}
    @include('profile.partials.navbar')
  @endunless

    {{-- ============================================
         FLASH MESSAGES
         ============================================ --}}
    <div class="container mt-3">
        @include('profile.partials.flash-messages')
    </div>

    {{-- ============================================
         MAIN CONTENT
         ============================================ --}}
    <main class="min-vh-100">
        @yield('content')
    </main>
@unless(request()->routeIs('login', 'register', 'password.*', 'verification.*'))
    {{-- ============================================
         FOOTER
         ============================================ --}}
    @include('profile.partials.footer')
@endunless

    {{-- Stack untuk JS tambahan per halaman --}}
    @stack('scripts')

    <script>
  /**
   * Fungsi AJAX untuk Toggle Wishlist
   * Menggunakan Fetch API (Modern JS) daripada jQuery.
   */
  async function toggleWishlist(productId) {
    try {
      // 1. Ambil CSRF token dari meta tag HTML
      // Laravale mewajibkan token ini untuk setiap request POST demi keamanan.
      const token = document.querySelector('meta[name="csrf-token"]').content;

      // 2. Kirim Request ke Server
      const response = await fetch(`/wishlist/toggle/${productId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": token, // Tempel token di header
        },
      });

      // 3. Handle jika user belum login (Error 401 Unauthorized)
      if (response.status === 401) {
        window.location.href = "/login"; // Lempar ke halaman login
        return;
      }

      // 4. Baca respon JSON dari server
      const data = await response.json();

      if (data.status === "success") {
        // 5. Update UI tanpa reload halaman
        updateWishlistUI(productId, data.added); // Ganti warna ikon
        updateWishlistCounter(data.count); // Update angka di header
        showToast(data.message); // Tampilkan notifikasi
      }
    } catch (error) {
      console.error("Error:", error);
      showToast("Terjadi kesalahan sistem.", "error");
    }
  }

  function updateWishlistUI(productId, isAdded) {
    // Cari semua tombol wishlist untuk produk ini (bisa ada di card & detail page)
    const buttons = document.querySelectorAll(`.wishlist-btn-${productId}`);

    buttons.forEach((btn) => {
      const icon = btn.querySelector("i"); // Menggunakan tag <i> untuk Bootstrap Icons
      if (isAdded) {
        // Ubah jadi merah solid (Love penuh)
        icon.classList.remove("bi-heart", "text-secondary");
        icon.classList.add("bi-heart-fill", "text-danger");
      } else {
        // Ubah jadi abu-abu outline (Love kosong)
        icon.classList.remove("bi-heart-fill", "text-danger");
        icon.classList.add("bi-heart", "text-secondary");
      }
    });
  }

  function updateWishlistCounter(count) {
    const badge = document.getElementById("wishlist-count");
    if (badge) {
      badge.innerText = count;
      // Bootstrap badge display toggle logic
      badge.style.display = count > 0 ? "inline-block" : "none";
    }
  }

  // Fungsi untuk ganti tema
    function toggleDarkMode() {
        const htmlElement = document.documentElement;
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        // Ganti atribut di HTML
        htmlElement.setAttribute('data-bs-theme', newTheme);
        
        // Simpan pilihan di browser
        localStorage.setItem('theme', newTheme);
        
        // Ganti icon
        updateIcon(newTheme);
    }

    // Fungsi update icon
    function updateIcon(theme) {
        const icon = document.getElementById('theme-icon');
        if (theme === 'dark') {
            icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
        } else {
            icon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
        }
    }

    // Jalankan saat halaman pertama kali dibuka
    (function () {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        updateIcon(savedTheme);
    })();
</script> 
</body>
</html>