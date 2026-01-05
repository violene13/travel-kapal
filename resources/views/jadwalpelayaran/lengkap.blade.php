        @extends('layouts.pengguna')

        @section('title', 'Jadwal Pelayaran Lengkap')

        @section('content')
        <div class="container py-4">

            {{-- FORM PENCARIAN --}}
            <form action="{{ route('jadwal.cari') }}" method="GET" class="card p-3 mb-4 shadow-sm border-0">
                <div class="row g-3">

                    {{-- === RINGKASAN PENCARIAN (Traveloka style) === --}}
                    @if(request()->filled('asal') || request()->filled('tujuan') || request()->filled('tanggal_berangkat'))
                        <div class="p-3 mb-4 rounded-3" 
                            style="background: #e8f3ff; border-left: 6px solid #2196f3;">

                            <h5 class="fw-bold text-primary mb-1">
                                {{ request('asal') }} ➜ {{ request('tujuan') }}
                            </h5>

                            @php
                                $dewasa = request('dewasa', 0);
                                $anak = request('anak', 0);
                                $bayi = request('bayi', 0);
                                $totalPenumpang = $dewasa + $anak + $bayi;
                            @endphp

                            <p class="mb-0 text-dark">
                                {{ request('tanggal_berangkat') 
                                    ? \Carbon\Carbon::parse(request('tanggal_berangkat'))->format('D, d M Y')
                                    : 'Tanggal tidak dipilih'
                                }}

                                &nbsp; | &nbsp;

                                {{ $totalPenumpang }} penumpang

                                &nbsp; | &nbsp;

                                {{ request('kelas') ?? 'Semua Kelas' }}
                            </p>
                        </div>
                    @endif

                </div>
            </form>

            {{-- ==== DAFTAR JADWAL ==== --}}
            <h2 class="mb-4 fw-bold text-primary">Jadwal</h2>

            @if($jadwal->count() === 0)
                <div class="alert alert-info">Belum ada jadwal pelayaran tersedia.</div>
            @endif

            <div class="row g-4">
                @foreach($jadwal as $j)
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">

                        {{-- GAMBAR KAPAL --}}
                        @if($j->kapal && $j->kapal->gambar_kapal)
                            <img 
                                src="{{ asset('images/kapal/' . $j->kapal->gambar_kapal) }}"
                                class="card-img-top"
                                style="height: 180px; width: 100%; object-fit: cover; object-position: center;"
                                alt="Foto Kapal">
                        @endif

                        <div class="card-body">

                            <h5 class="fw-bold text-dark">
                                {{ $j->kapal->nama_kapal ?? 'Nama kapal tidak tersedia' }}
                            </h5>

                            <p class="fw-semibold text-dark mb-2">
                                {{ $j->jalur->pelabuhanAsal->lokasi ?? '-' }}
                                →
                                {{ $j->jalur->pelabuhanTujuan->lokasi ?? '-' }}
                            </p>

                            <p class="mb-2">
                                <i class="bi bi-calendar-date"></i>
                                {{ \Carbon\Carbon::parse($j->tanggal_berangkat)->format('d M Y') }}

                                &nbsp; | &nbsp;

                                <i class="bi bi-clock"></i>
                                {{ substr($j->jam_berangkat, 0, 5) }}
                                -
                                {{ substr($j->jam_tiba, 0, 5) }}
                            </p>

                            <p class="mb-2">
                                <i class="bi bi-building"></i>
                                <b>{{ $j->kelas ?? 'Tidak ada kelas' }}</b>
                            </p>

                            <p class="fw-semibold text-primary mb-3">
                                Rp {{ number_format($j->harga ?? 0, 0, ',', '.') }}
                            </p>

                            <div class="mt-3 text-end">
                                <a href="{{ route('jadwal.detail', $j->id_jadwal) }}" class="btn btn-primary">
                                    Detail
                                </a>

                                @if(auth('penumpang')->check())
                                    <a href="{{ route('pemesanan.pemesananpengguna.create', $j->id_jadwal) }}"
                                    class="btn btn-primary ms-2">
                                        Pesan Sekarang
                                    </a>
                                @else
                                    <a href="#"
                                    class="btn btn-primary ms-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
                                        Pesan Sekarang
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
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
