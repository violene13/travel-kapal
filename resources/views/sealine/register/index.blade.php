@extends('layouts.pengguna')

@section('title', 'Daftar')

@section('content')
<style>
    body {
        background-color: #ffffff;
        background-image: url('{{ asset("images/daftar.jpeg") }}');
        background-repeat: no-repeat;
        background-position: center 100px;
        background-size: 65%;
        font-family: 'Poppins', sans-serif;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }

    /* === card form === */
    .register-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 25px 30px;
        width: 100%;
        max-width: 420px;
        border: 1px solid #ddd;
    }

    /* === JUDUL === */
    .register-card h4 {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    /* === INPUT DAN LABEL === */
    label {
        font-size: 13px;
        font-weight: 400;
        color: #444;
        margin-bottom: 3px;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ccc;
        padding: 7px 9px;
        font-size: 13px;
    }

    /* === SPASI ANTAR FORM === */
    .mb-3 {
        margin-bottom: 10px !important;
    }

    .d-flex.gap-2 .form-control {
        flex: 1;
    }

    /* === TOMBOL === */
    .btn-register {
        background-color: #007bff;
        border: none;
        border-radius: 6px;
        padding: 8px 0;
        font-weight: 500;
        transition: 0.3s;
        color: white;
        font-size: 13px;
    }

    .btn-register:hover {
        background-color: #0056b3;
    }

    /* === LINK LOGIN === */
    .login-link {
        text-align: center;
        margin-top: 10px;
        font-size: 13px;
    }

    .login-link a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    /* === ICON PASSWORD === */
    .position-relative span {
        color: #555;
        font-size: 13px;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        body {
            background-size: 90%;
            background-position: center 80px;
        }
        .register-card {
            padding: 20px;
        }
    }
</style>

<div class="register-wrapper">
    <div class="register-card">
        <h4><i class=></i>Registrasi</h4>

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li style="font-size: 13px;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success text-center py-2" style="font-size: 13px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3 position-relative">
                <label>Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <span class="position-absolute" style="top:32px; right:12px; cursor:pointer;" onclick="togglePassword('password', this)">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>

            <div class="mb-3 position-relative">
                <label>Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                <span class="position-absolute" style="top:32px; right:12px; cursor:pointer;" onclick="togglePassword('password_confirmation', this)">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>

            <div class="mb-3">
                <label>No. Handphone</label>
                <input type="text" name="no_hp" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>No. KTP</label>
                <input type="text" name="no_ktp" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Gender</label><br>
                <div class="form-check form-check-inline" style="font-size: 13px;">
                    <input class="form-check-input" type="radio" name="gender" id="genderL" value="L" required>
                    <label class="form-check-label" for="genderL">Laki-Laki</label>
                </div>
                <div class="form-check form-check-inline" style="font-size: 13px;">
                    <input class="form-check-input" type="radio" name="gender" id="genderP" value="P" required>
                    <label class="form-check-label" for="genderP">Perempuan</label>
                </div>
            </div>

            <div class="mb-3">
                <label>Tanggal Lahir</label>
                <div class="d-flex gap-2">
                    <input type="number" name="tahun" placeholder="Tahun" min="1900" max="2100" class="form-control" required>
                    <input type="number" name="bulan" placeholder="Bulan" min="1" max="12" class="form-control" required>
                    <input type="number" name="tanggal" placeholder="Tanggal" min="1" max="31" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-register w-100 mt-2">
                <i class="fa-solid fa-paper-plane me-1"></i> Daftar Sekarang
            </button>

            <p class="login-link">
                Sudah punya akun?
                <a href="{{ route('sealine.homes.index') }}#loginModal"
                   onclick="event.preventDefault(); openLoginModal();">Login di sini</a>
            </p>
        </form>
    </div>
</div>

<script>
function togglePassword(id, el) {
    const input = document.getElementById(id);
    const icon = el.querySelector("i");
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}

function openLoginModal() {
    window.location.href = "{{ route('sealine.homes.index') }}?showLogin=true";
}
</script>
@endsection
