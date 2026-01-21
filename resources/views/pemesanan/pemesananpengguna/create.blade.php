@extends('layouts.pengguna')

@section('content')
<div class="container py-4">

<form action="{{ route('pemesanan.pemesananpengguna.store', $jadwal->id_jadwal) }}"
      method="POST">
@csrf

<input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">

{{-- ================= DEWASA ================= --}}
<div class="mb-4">
    <div class="d-flex justify-content-between mb-2">
        <h5>Dewasa</h5>
        <button type="button" class="btn btn-sm btn-outline-primary"
                onclick="tambahForm('dewasa')">
            Tambah Dewasa
        </button>
    </div>
    <div id="dewasa-wrapper"></div>
</div>

{{-- ================= ANAK ================= --}}
<div class="mb-4">
    <div class="d-flex justify-content-between mb-2">
        <h5>Anak</h5>
        <button type="button" class="btn btn-sm btn-outline-warning"
                onclick="tambahForm('anak')">
            Tambah Anak
        </button>
    </div>
    <div id="anak-wrapper"></div>
</div>

{{-- ================= BAYI ================= --}}
<div class="mb-4">
    <div class="d-flex justify-content-between mb-2">
        <h5>Bayi</h5>
        <button type="button" class="btn btn-sm btn-outline-info"
                onclick="tambahForm('bayi')">
            Tambah Bayi
        </button>
    </div>
    <div id="bayi-wrapper"></div>
</div>

<hr>

{{-- ================= RINGKASAN ================= --}}
<div class="fw-bold mb-2">Ringkasan Harga</div>

<div class="d-flex justify-content-between small">
    <span>Dewasa x <span id="count-dewasa">0</span></span>
    <span>Rp <span id="total-dewasa">0</span></span>
</div>

<div class="d-flex justify-content-between small">
    <span>Anak x <span id="count-anak">0</span></span>
    <span>Rp <span id="total-anak">0</span></span>
</div>

<div class="d-flex justify-content-between small mb-2">
    <span>Bayi x <span id="count-bayi">0</span></span>
    <span>Rp <span id="total-bayi">0</span></span>
</div>

<hr>

<div class="d-flex justify-content-between fw-bold">
    <span>Total</span>
    <span>Rp <span id="grand-total">0</span></span>
</div>

<button type="submit" class="btn btn-primary mt-3 fw-bold">
    Lanjutkan Pemesanan
</button>

<a href="{{ route('jadwal.cari', $jadwal->id_jadwal) }}"
   class="btn btn-secondary mt-3 fw-bold ms-2">
    Kembali
</a>

</form>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
const hargaPerKelas = @json($hargaPerKelas);
const TAHUN_ACUAN = 2026;

let index = { dewasa: 0, anak: 0, bayi: 0 };

function generateTanggal() {
    let opt = '<option value="">Tanggal</option>';
    for (let i = 1; i <= 31; i++) {
        opt += `<option value="${i}">${i}</option>`;
    }
    return opt;
}

function generateBulan() {
    let opt = '<option value="">Bulan</option>';
    for (let i = 1; i <= 12; i++) {
        opt += `<option value="${i}">${i}</option>`;
    }
    return opt;
}

function generateTahunByTipe(tipe) {
    let opt = '<option value="">Tahun</option>';

    if (tipe === 'bayi') {
        [2026, 2025].forEach(t => {
            opt += `<option value="${t}">${t}</option>`;
        });
    }

    if (tipe === 'anak') {
        for (let t = 2024; t >= 2015; t--) {
            opt += `<option value="${t}">${t}</option>`;
        }
    }

    if (tipe === 'dewasa') {
        for (let t = 2014; t >= 1925; t--) {
            opt += `<option value="${t}">${t}</option>`;
        }
    }

    return opt;
}

function tambahForm(tipe) {
    const wrapper = document.getElementById(`${tipe}-wrapper`);
    const i = index[tipe]++;

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="card mb-3 penumpang-card" data-tipe="${tipe}">
            <div class="card-header d-flex justify-content-between">
                <strong>${tipe.toUpperCase()} ${i + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger"
                        onclick="this.closest('.card').remove(); updateTotal();">
                    Hapus
                </button>
            </div>

            <div class="card-body">
                <input type="text"
                       name="${tipe}[${i}][nama_lengkap]"
                       class="form-control mb-2"
                       placeholder="Nama Lengkap"
                       required>

                <select name="${tipe}[${i}][kelas]"
                        class="form-select mb-2 kelas-select"
                        onchange="updateTotal()">
                    ${Object.keys(hargaPerKelas).map(k =>
                        `<option value="${k}">${k}</option>`
                    ).join('')}
                </select>

                <div class="row g-2">
                    <div class="col">
                        <select name="${tipe}[${i}][tanggal]" class="form-select" required>
                            ${generateTanggal()}
                        </select>
                    </div>
                    <div class="col">
                        <select name="${tipe}[${i}][bulan]" class="form-select" required>
                            ${generateBulan()}
                        </select>
                    </div>
                    <div class="col">
                        <select name="${tipe}[${i}][tahun]" class="form-select" required>
                            ${generateTahunByTipe(tipe)}
                        </select>
                    </div>
                </div>

            </div>
        </div>
    `);

    updateTotal();
}

function updateTotal() {
    let total = 0;

    const recap = {
        dewasa: { count: 0, total: 0 },
        anak:   { count: 0, total: 0 },
        bayi:   { count: 0, total: 0 }
    };

    document.querySelectorAll('.penumpang-card').forEach(card => {
        const tipe  = card.dataset.tipe;
        const kelas = card.querySelector('.kelas-select').value;

        const harga = hargaPerKelas[kelas]?.[tipe] ?? 0;

        recap[tipe].count++;
        recap[tipe].total += harga;
        total += harga;
    });

    ['dewasa','anak','bayi'].forEach(tipe => {
        document.getElementById(`count-${tipe}`).innerText = recap[tipe].count;
        document.getElementById(`total-${tipe}`).innerText =
            recap[tipe].total.toLocaleString('id-ID');
    });

    document.getElementById('grand-total').innerText =
        total.toLocaleString('id-ID');
}

tambahForm('dewasa');
</script>
@endsection
