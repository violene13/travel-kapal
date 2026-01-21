@extends('layouts.pengguna')

@section('title', 'Beranda Sealine')

@section('content')
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

<section class="hero position-relative text-white" style="margin-top: 0;">
    <img src="{{ asset('images/kapal.jpg') }}"
         alt="Sealine"
         class="w-100 d-block"
         style="height: 93vh; object-fit: cover; object-position: center 20%; image-rendering: crisp-edges; margin-top:-155px;">
         
    <div class="position-absolute bottom-0 start-0 p-4 w-60 text-start">
        <h1 class="fw-bold" style="font-size: 2rem; text-shadow: 3px 3px 10px rgba(0,0,0,0.8);">
            Pesan Tiket Kapal Penumpang dengan Mudah dan Cepat
        </h1>
    </div>
</section>

<section class="container my-5">
    <h4 class="fw-bold mb-3">Cari Jadwal Anda</h4>
    <div class="p-4 border rounded-3 shadow-sm bg-white">

        <form class="row g-3 align-items-end" method="GET" action="{{ route('jadwal.cari') }}">

            <div class="col-md-2">
                <label class="form-label fw-semibold">Jenis Perjalanan</label>
                <select id="tripType" class="form-select" name="jenis_perjalanan">
                    <option value="sekali" selected>Sekali Jalan</option>
                    <option value="pp">Pulang Pergi</option>
                </select>
            </div>

            <div class="col-md-3 position-relative" id="passengerDropdown">
                <label class="form-label fw-semibold">Penumpang</label>
                <div class="dropdown">
                    <button class="form-select text-start" type="button" data-bs-toggle="dropdown">
                        <span id="passengerSummary">0 Dewasa, 0 Anak, 0 Bayi</span>
                    </button>

                    <div class="dropdown-menu p-3 shadow" style="width: 250px;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Dewasa</span>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary count-btn"
                                        data-type="dewasa" data-delta="-1">−</button>
                                <span id="dewasaCount" class="mx-2">0</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary count-btn"
                                        data-type="dewasa" data-delta="1">+</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Anak</span>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary count-btn"
                                        data-type="anak" data-delta="-1">−</button>
                                <span id="anakCount" class="mx-2">0</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary count-btn"
                                        data-type="anak" data-delta="1">+</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span>Bayi</span>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary count-btn"
                                        data-type="bayi" data-delta="-1">−</button>
                                <span id="bayiCount" class="mx-2">0</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary count-btn"
                                        data-type="bayi" data-delta="1">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="dewasa" id="dewasaInput" value="0">
            <input type="hidden" name="anak" id="anakInput" value="0">
            <input type="hidden" name="bayi" id="bayiInput" value="0">

            <div class="col-md-2">
                <label class="form-label fw-semibold">Kelas</label>
                <select class="form-select" name="kelas">
                    <option selected>Ekonomi</option>
                    <option>Bisnis</option>
                    <option>VIP</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Asal</label>
                <select name="asal" class="form-select" required>
                    <option value="">Pilih Asal</option>
                    @foreach ($pelabuhan as $p)
                        <option value="{{ $p->lokasi }}">{{ $p->lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Tujuan</label>
                <select name="tujuan" class="form-select" required>
                    <option value="">Pilih Tujuan</option>
                    @foreach ($pelabuhan as $p)
                        <option value="{{ $p->lokasi }}">{{ $p->lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Tanggal Berangkat</label>
                <input type="date" id="tanggalBerangkat" name="tanggal_berangkat" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold">Tanggal Pulang</label>
                <input type="date" id="tanggalPulang" name="tanggal_pulang" class="form-control" disabled>
            </div>

            <div class="col-md-2 text-center">
                <button type="submit" class="btn btn-primary w-100 mt-4">Search</button>
            </div>

        </form>
    </div>
</section>

<section class="container mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Jadwal & Rute Populer</h4>

        <a href="{{ route('jadwal.lengkap') }}" 
           class="text-primary fw-semibold text-decoration-none">
            Lihat selengkapnya 
        </a>
    </div>

    <div class="row g-4">

        @forelse ($rutePopuler as $rute)
            <div class="col-md-3">
                <div class="card shadow-sm h-100 border-0 rounded-3">

                    <img 
                        src="{{ asset('images/kapal/' . $rute->kapal->gambar_kapal) }}" 
                        alt="{{ $rute->kapal->nama_kapal }}" 
                        class="card-img-top"
                        style="height: 170px; object-fit: cover;">
                    
                    <div class="card-body">

                        <h6 class="fw-bold text-primary mb-1">
                            {{ $rute->kapal->nama_kapal }}
                        </h6>

                        <p class="fw-semibold text-dark mb-2">
                            {{ $rute->jalur->pelabuhanAsal->lokasi ?? '-' }} 
                            → 
                            {{ $rute->jalur->pelabuhanTujuan->lokasi ?? '-' }}
                        </p>

                        <p class="mb-1 text-muted small">
                            <i class="bi bi-calendar-check me-1"></i>
                            {{ \Carbon\Carbon::parse($rute->tanggal_berangkat)->format('d M Y') }}
                        </p>

                        <p class="mb-2 text-muted small">
                            <i class="bi bi-clock me-1"></i>
                            {{ substr($rute->jam_berangkat, 0, 5) }}
                        </p>

                        <p class="mb-2">
                            <i class="bi bi-building"></i>
                            <b>{{ $rute->kelas }}</b>
                        </p>

                        <p class="fw-semibold text-primary mb-3">
                            Rp {{ number_format($rute->harga, 0, ',', '.') }}
                        </p>

                        @if(Auth::check() && Auth::user()->role === 'penumpang')
                            <a href="{{ route('pemesanan.pemesananpengguna.create', $rute->id_jadwal) }}"
                            class="btn btn-primary w-100">
                                Pesan Sekarang
                            </a>
                        @else
                            <a href="{{ route('sealine.homes.index', ['login' => 1]) }}"
                            class="btn btn-primary w-100">
                                Pesan Sekarang
                            </a>
                        @endif


                    </div>
                </div>
            </div>

        @empty
            <p class="text-muted">Tidak ada rute populer tersedia.</p>
        @endforelse

    </div>

</section>

<!-- =========================== -->
<!--  LOGIN MODAL (FIXED) -->
<!-- =========================== -->
<div class="modal fade"
     id="loginModal"
     tabindex="-1"
     aria-labelledby="loginModalLabel"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4" style="background: #ffffff;">
      
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold text-primary w-100 text-center" id="loginModalLabel">
          <i class="fa-solid fa-ship me-2"></i>Login Sealine
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body px-4 pb-4">
        
        @if($errors->has('login_error'))
          <div class="alert alert-danger text-center py-2">
            {{ $errors->first('login_error') }}
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
                  style="cursor:pointer" onclick="togglePassword()">
              <i class="fa fa-eye" id="togglePasswordIcon"></i>
            </span>
          </div>

          <button type="submit" 
                  class="btn w-100 text-white fw-semibold py-2 rounded-pill"
                  style="background: linear-gradient(90deg, #0099cc, #00c2a8);">
            Masuk
          </button>
        </form>

        <div class="text-center mt-3">
          Belum punya akun?
          <a href="{{ route('register') }}" class="fw-semibold text-primary">
            Daftar di sini
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
/* =======================
   AUTO OPEN LOGIN MODAL
======================= */
document.addEventListener('DOMContentLoaded', function () {
    @if(!Auth::check() && (request()->has('login') || $errors->has('login_error')))
        new bootstrap.Modal(document.getElementById('loginModal')).show();
    @endif
});

/* =======================
   TOGGLE PASSWORD
======================= */
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('togglePasswordIcon');

    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';

    icon.classList.toggle('fa-eye', !isHidden);
    icon.classList.toggle('fa-eye-slash', isHidden);
}

/* =======================
   PASSENGER COUNTER
======================= */
document.querySelectorAll('#passengerDropdown .dropdown-menu')
    .forEach(menu => menu.addEventListener('click', e => e.stopPropagation()));

document.querySelectorAll('.count-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const type = btn.dataset.type;
        const delta = parseInt(btn.dataset.delta);

        const countEl = document.getElementById(type + 'Count');
        const newVal  = Math.max(0, parseInt(countEl.textContent) + delta);
        countEl.textContent = newVal;

        const dewasa = +dewasaCount.textContent;
        const anak   = +anakCount.textContent;
        const bayi   = +bayiCount.textContent;

        passengerSummary.textContent =
            `${dewasa} Dewasa, ${anak} Anak, ${bayi} Bayi`;

        dewasaInput.value = dewasa;
        anakInput.value   = anak;
        bayiInput.value   = bayi;
    });
});

/* =======================
   TRIP TYPE (PP)
======================= */
document.getElementById('tripType').addEventListener('change', function () {
    const pulang = document.getElementById('tanggalPulang');
    pulang.disabled = this.value !== 'pp';
    if (this.value !== 'pp') pulang.value = '';
});
</script>


@endsection
