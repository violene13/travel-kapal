<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Sealine')</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Poppins', sans-serif;
    background:#f8f9fa;
    margin:0;
    padding:0;
}
nav.navbar {
    position: fixed; top:0; left:0; width:100%;
    z-index:1030; background:#004080;
    backdrop-filter: blur(8px);
    padding:12px 0;
    transition: background 0.3s ease;
}
nav.navbar.scrolled {
    background:#004080;
    box-shadow:0 2px 8px rgba(0,0,0,0.2);
}
nav.navbar a.nav-link {
    color:white !important;
    font-weight:500;
    transition: color 0.2s;
}
nav.navbar a.nav-link:hover { color:#ffdd57 !important; }
nav.navbar .navbar-brand {
    color:white !important;
    font-weight:700;
    letter-spacing:0.5px;
}
.navbar .btn-daftar {
    background: rgba(255,255,255,0.15);
    color:#fff !important;
    font-weight:600;
    border:1px solid rgba(255,255,255,0.4);
    border-radius:10px;
    padding:6px 18px;
    backdrop-filter:blur(6px);
    box-shadow:0 2px 10px rgba(255,255,255,0.15);
    transition: all 0.3s ease;
}
.navbar .btn-daftar:hover {
    background: rgba(255,255,255,0.3);
    color:#004080 !important;
    box-shadow:0 4px 12px rgba(255,255,255,0.25);
}
footer {
    background:#004080;
    color: rgba(255,255,255,0.85);
    text-align:center;
    padding:20px 0;
    margin-top:80px;
    font-size:0.9rem;
    letter-spacing:0.3px;
}
footer p { margin:0; font-weight:400; }
main { padding-top:0 !important; }

</style>
</head>

<body> <!-- DIBIARKAN -->

@php
    $isPenumpang = Auth::guard('penumpang')->check();
@endphp

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark">
<div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('sealine.homes.index') }}">SEALINE</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

        <ul class="navbar-nav align-items-center">

          {{-- Riwayat (HANYA PENUMPANG) --}}
    @if ($isPenumpang)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                Riwayat
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item"
                       href="{{ route('pemesanan.pemesananpengguna.index') }}">
                        Pemesanan Saya
                    </a>
                </li>
            </ul>
        </li>
    @endif

    {{-- Bantuan --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sealine.bantuan.index') }}">Bantuan</a>
    </li>

    {{-- Tentang Kami --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('sealine.aboutus.index') }}">Tentang Kami</a>
    </li>

    {{-- JIKA BELUM LOGIN (TIDAK PEDULI ADMIN) --}}
    @if (!$isPenumpang)
        <li class="nav-item">
            <a class="nav-link" href="{{ route('sealine.homes.index', ['login' => 1]) }}">
                Masuk
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn-daftar ms-2" href="{{ route('register') }}">
                Daftar
            </a>
        </li>
    @endif

{{-- JIKA PENUMPANG LOGIN --}}
@if ($isPenumpang)
@php
    $penumpang = Auth::guard('penumpang')->user();

    if (
        empty($penumpang->foto) ||
        !\Illuminate\Support\Facades\Storage::disk('public')->exists($penumpang->foto)
    ) {
        $fotoProfil = asset('images/default-avatar.png');
    } else {
        $fotoProfil = asset('storage/' . $penumpang->foto);
    }
@endphp



<li class="nav-item dropdown ms-3">
    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
       href="#" data-bs-toggle="dropdown">

        <img
            src="{{ $fotoProfil }}"
            alt="Foto Profil"
            width="32"
            height="32"
            class="rounded-circle"
            style="object-fit:cover; border:2px solid rgba(255,255,255,0.7);">

        <span>{{ $penumpang->nama_penumpang }}</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a class="dropdown-item" href="{{ route('penumpang.profil') }}">
                <i class="fa fa-user me-2"></i> Profil Saya
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dropdown-item text-danger">
                    <i class="fa fa-right-from-bracket me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</li>
@endif


        </ul>

    </div> <!-- END collapse -->
</div> <!-- END container -->
</nav>

<!-- MODAL RIWAYAT -->
<div class="modal fade" id="riwayatModal" tabindex="-1" aria-labelledby="riwayatModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background:#004080; color:white;">
        <h5 class="modal-title fw-bold" id="riwayatModalLabel">Riwayat Pemesanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p class="text-muted text-center">Belum ada riwayat pemesanan.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- ISI HALAMAN -->
<main style="min-height: calc(100vh - 120px); margin-top: 90px;">
    @yield('content')
</main>


<!-- FOOTER -->
<footer>
  <p class="mb-0">© 2025 Sealine — Semua Hak Dilindungi</p>
</footer>

<!-- MODAL LOGIN -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius:16px;">
      <div class="modal-header border-0">
        <h5 class="modal-title text-white fw-bold" id="loginModalLabel">Login Sealine</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">

        <!-- Perbaikan: Tambah @csrf -->
        <form action="#" method="POST">
          @csrf

          <div class="mb-3 position-relative">
            <span class="input-group-text position-absolute top-50 translate-middle-y ps-2">
              <i class="fa fa-user text-white"></i>
            </span>
            <input type="text" name="username" class="form-control ps-5" placeholder="Username atau Email" required>
          </div>

          <div class="mb-3 position-relative">
            <span class="input-group-text position-absolute top-50 translate-middle-y ps-2">
              <i class="fa fa-lock text-white"></i>
            </span>
            <input type="password" name="password" class="form-control ps-5" placeholder="Password" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>

        <div class="text-center mt-3 text-white">
          Belum punya akun? <a href="{{ route('register') }}" class="text-info">Daftar di sini</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Navbar Scroll Effect -->
<script>
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('scrolled', window.scrollY > 30);
});
</script>

<!-- AUTO OPEN LOGIN MODAL IF ?login=1 -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('login') === '1') {
        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }
});
</script>

</body>
</html>
