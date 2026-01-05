@extends('layouts.pengguna')

@section('content')
<div class="container py-4">

    <form id="formPemesanan"
      action="{{ route('pemesanan.pemesananpengguna.store', $jadwal->id_jadwal) }}"
      method="POST">
    @csrf


        {{-- ======================================================
            FORM DEWASA
        ======================================================= --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Dewasa 1
            </div>
            <div class="card-body">
                <div class="alert alert-warning small">
                    ⚠️ Perhatikan hal berikut <br>
                    Masukkan nama sesuai dengan yang ada di KTP.
                    Kesalahan penulisan dapat menyebabkan gagal check-in.
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="dewasa[0][nama_lengkap]" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- ======================================================
            FORM ANAK
        ======================================================= --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Anak 1
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="anak[0][nama_lengkap]" class="form-control" required>
                    </div>

                <label class="form-label">Tanggal Lahir</label>
                <div class="row g-2">
                    <div class="col-4">
                        <input type="number" placeholder="DD" name="anak[0][tanggal]" class="form-control" min="1" max="31" required>
                    </div>
                    <div class="col-4">
                        <input type="number" placeholder="MM" name="anak[0][bulan]" class="form-control" min="1" max="12" required>
                    </div>
                    <div class="col-4">
                        <input type="number" placeholder="YYYY" name="anak[0][tahun]" class="form-control" min="1900" max="2100" required>
                    </div>
                </div>

            </div>
        </div>

        {{-- ======================================================
            FORM BAYI
        ======================================================= --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white fw-bold">
                Bayi 1
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="bayi[0][nama_lengkap]" class="form-control" required>
                    </div>

                <label class="form-label">Tanggal Lahir</label>
                <div class="row g-2">
                    <div class="col-4">
                        <input type="number" placeholder="DD" name="bayi[0][tanggal]" class="form-control" min="1" max="31" required>
                    </div>
                    <div class="col-4">
                        <input type="number" placeholder="MM" name="bayi[0][bulan]" class="form-control" min="1" max="12" required>
                    </div>
                    <div class="col-4">
                        <input type="number" placeholder="YYYY" name="bayi[0][tahun]" class="form-control" min="1900" max="2100" required>
                    </div>
                </div>

            </div>
        </div>

        {{-- ======================================================
            RINCIAN HARGA
        ======================================================= --}}
      <div class="d-flex justify-content-between small mb-1">
    <span>{{ $jadwal->kapal->nama_kapal }} (Dewasa) x{{ $dewasa }}</span>
    <span>Rp {{ number_format($harga['dewasa'] * $dewasa, 0, ',', '.') }}</span>
</div>

<div class="d-flex justify-content-between small mb-1">
    <span>{{ $jadwal->kapal->nama_kapal }} (Anak) x{{ $anak }}</span>
    <span>Rp {{ number_format($harga['anak'] * $anak, 0, ',', '.') }}</span>
</div>

<div class="d-flex justify-content-between small mb-2">
    <span>{{ $jadwal->kapal->nama_kapal }} (Bayi) x{{ $bayi }}</span>
    <span>Rp {{ number_format($harga['bayi'] * $bayi, 0, ',', '.') }}</span>
</div>

<hr>

<div class="d-flex justify-content-between fw-bold">
    <span>Total Harga</span>
    <span>
        Rp {{
            number_format(
                ($harga['dewasa'] * $dewasa) +
                ($harga['anak'] * $anak) +
                ($harga['bayi'] * $bayi),
            0, ',', '.')
        }}
    </span>
</div>

<button class="btn btn-primary w-100 py-2 fw-bold">Lanjut Pembayaran</button>

    </form>
</div>
<script>
document.getElementById('formPemesanan').addEventListener('submit', function (e) {
    e.preventDefault(); // tahan submit dulu

    Swal.fire({
        title: 'Lanjut ke Pembayaran?',
        text: 'Pastikan data penumpang sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Bayar Sekarang',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit(); // lanjut submit form
        }
    });
});
</script>

@endsection
