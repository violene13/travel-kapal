@extends('layouts.pengguna')

@section('title', 'Detail Pelayaran')

@section('content')
<div class="container py-4">

    {{-- GAMBAR KAPAL FULL WIDTH --}}
    @if($jadwal->kapal->gambar_kapal ?? false)
    <div class="card border-0 shadow-sm mb-4">
        <img src="{{ asset('images/kapal/' . $jadwal->kapal->gambar_kapal) }}"
             class="w-100"
             style="height: 280px; object-fit: cover; border-radius: 6px;">
    </div>
    @endif

    {{-- CARD DETAIL --}}
    <div class="card shadow-sm border-0 p-4">

        {{-- NAMA KAPAL --}}
        <h4 class="fw-bold mb-4">{{ $jadwal->kapal->nama_kapal }}</h4>
        <h4 class="mb-2">
            <i class="bi bi-building"></i>
            <b>{{ $jadwal->kelas ?? 'Tidak ada kelas' }}</b>
        </h4>

        <div class="row text-center">

            {{-- BERANGKAT --}}
            <div class="col-4">
                <h5 class="mb-1">{{ date('H.i', strtotime($jadwal->jam_berangkat)) }}</h5>
                <p class="mb-1">{{ date('j F Y', strtotime($jadwal->tanggal_berangkat)) }}</p>
                <p class="small text-muted">
                    {{ $jadwal->jalur->pelabuhanAsal->lokasi }} <br>
                    Pelabuhan {{ $jadwal->jalur->pelabuhanAsal->nama_pelabuhan ?? '-' }}
                </p>
            </div>

            {{-- TENGAH: DURASI + KURSI --}}
            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                <p class="fw-bold mb-2">{{ $jadwal->durasi ?? '3j' }}</p>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-chair fs-4"></i>
                    <span>Satu Kursi</span>
                </div>
            </div>

            {{-- TIBA --}}
            <div class="col-4">
                <h5 class="mb-1">{{ date('H.i', strtotime($jadwal->jam_tiba)) }}</h5>
                <p class="mb-1">{{ date('j F Y', strtotime($jadwal->tanggal_tiba)) }}</p>
                <p class="small text-muted">
                    {{ $jadwal->jalur->pelabuhanTujuan->lokasi }} <br>
                    Pelabuhan {{ $jadwal->jalur->pelabuhanTujuan->nama_pelabuhan ?? '-' }}
                </p>
            </div>

        </div>

        <hr class="my-4">

        {{-- HARGA --}}
        <div class="text-center mb-4">
            <p class="fw-bold mb-1">Harga</p>
            <h5 class="text-primary">
                Rp{{ number_format($jadwal->harga, 0, ',', '.') }}/org
            </h5>
        </div>

        {{-- TOMBOL PESAN --}}
        <div class="text-center">
            @if(auth('penumpang')->check())
                <a href="{{ route('pemesanan.pemesananpengguna.create', $jadwal->id_jadwal) }}"
                   class="btn btn-primary">
                    Pesan Sekarang
                </a>
            @else
                <a href="#"
                   class="btn btn-primary"
                   data-bs-toggle="modal"
                   data-bs-target="#loginModal">
                    Pesan Sekarang
                </a>
            @endif
        </div>

        {{-- KEMBALI --}}
        <div class="text-center mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </div>
</div>

<!-- =========================== -->
<!-- 🔹 LOGIN MODAL -->
<!-- =========================== -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4" style="background: #ffffff;">
        
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-primary w-100 text-center" id="loginModalLabel">
                    <i class="fa-solid fa-ship me-2"></i>Login Sealine
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 pb-4">

                {{-- Pesan Error --}}
                @if($errors->has('login_error'))
                <div class="alert alert-danger text-center py-2">
                    {{ $errors->first('login_error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success text-center py-2">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-3 position-relative">
                        <span class="position-absolute top-50 translate-middle-y ps-3 text-secondary">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="text" name="username" 
                               class="form-control ps-5 py-2 rounded-pill border border-secondary-subtle" 
                               placeholder="Username atau Email" required>
                    </div>

                    <div class="mb-3 position-relative">
                        <span class="position-absolute top-50 translate-middle-y ps-3 text-secondary">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" 
                               class="form-control ps-5 pe-5 py-2 rounded-pill border border-secondary-subtle" 
                               placeholder="Password" required>
                        <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-secondary" 
                              style="cursor: pointer;" onclick="togglePassword()">
                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                        </span>
                    </div>

                    <button type="submit" 
                            class="btn w-100 text-white fw-semibold py-2 rounded-pill"
                            style="background: linear-gradient(90deg, #0099cc, #00c2a8); border: none;">
                        Masuk
                    </button>
                </form>

                <div class="text-center mt-3">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">
                        Daftar di sini
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- 🔥 AUTO SHOW MODAL KETIKA ADA ERROR ATAU SUCCESS -->
@if($errors->has('login_error') || session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    });
</script>
@endif

<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.getElementById("togglePasswordIcon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

<style>
#loginModal .modal-content {
    animation: fadeIn 0.25s ease-in-out;
}
#loginModal input:focus {
    border-color: #00c2a8;
    box-shadow: 0 0 6px rgba(0,194,168,0.3);
}
#loginModal .btn:hover {
    background: linear-gradient(90deg, #00c2a8, #0099cc);
    transform: translateY(-1px);
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>

@endsection
