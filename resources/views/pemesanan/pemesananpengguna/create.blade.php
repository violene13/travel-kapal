@extends('layouts.pengguna')

@section('content')
<div class="container py-4">

<form id="formPemesanan"
      action="{{ route('pemesanan.pemesananpengguna.store', $jadwal->id_jadwal) }}"
      method="POST">
@csrf

<input type="hidden" name="id_jadwal" value="{{ $jadwal->id_jadwal }}">

<div class="mb-4">
    <div class="d-flex justify-content-between mb-2">
        <h5>Dewasa</h5>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="tambahForm('dewasa')">
            Tambah Dewasa
        </button>
    </div>
    <div id="dewasa-wrapper"></div>
</div>

<div class="mb-4">
    <div class="d-flex justify-content-between mb-2">
        <h5>Anak</h5>
        <button type="button" class="btn btn-sm btn-outline-warning" onclick="tambahForm('anak')">
            Tambah Anak
        </button>
    </div>
    <div id="anak-wrapper"></div>
</div>

<div class="mb-4">
    <div class="d-flex justify-content-between mb-2">
        <h5>Bayi</h5>
        <button type="button" class="btn btn-sm btn-outline-info" onclick="tambahForm('bayi')">
           Tambah Bayi
        </button>
    </div>
    <div id="bayi-wrapper"></div>
</div>

<hr>

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

<button type="submit" class="btn btn-primary w-25 mt-3 fw-bold">
    Lanjutkan Pemesanan
</button>

 <a href="{{ route('jadwal.cari', $jadwal->id_jadwal) }}"
       class="btn btn-outline-secondary fw-bold px-4">
        Kembali
    </a>

</form>
</div>


<script>
const harga = @json($harga);

let index = { dewasa: 0, anak: 0, bayi: 0 };

function tambahForm(tipe) {
    const wrapper = document.getElementById(`${tipe}-wrapper`);
    const i = index[tipe]++;

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <strong>${tipe.toUpperCase()} ${i + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.card').remove(); updateTotal();">
                    Hapus
                </button>
            </div>
            <div class="card-body">
                <input type="text" name="${tipe}[${i}][nama_lengkap]"
                       class="form-control mb-2"
                       placeholder="Nama Lengkap" required>

                ${tipe !== 'dewasa' ? `
                <div class="row g-2">
                    <div class="col">
                        <input type="number" name="${tipe}[${i}][tanggal]" placeholder="DD" class="form-control" required>
                    </div>
                    <div class="col">
                        <input type="number" name="${tipe}[${i}][bulan]" placeholder="MM" class="form-control" required>
                    </div>
                    <div class="col">
                        <input type="number" name="${tipe}[${i}][tahun]" placeholder="YYYY" class="form-control" required>
                    </div>
                </div>` : ``}
            </div>
        </div>
    `);

    updateTotal();
}

function updateTotal() {
    ['dewasa','anak','bayi'].forEach(tipe => {
        const jumlah = document.querySelectorAll(`#${tipe}-wrapper .card`).length;
        document.getElementById(`count-${tipe}`).innerText = jumlah;
        document.getElementById(`total-${tipe}`).innerText =
            (jumlah * (harga[tipe] ?? 0)).toLocaleString('id-ID');
    });

    const total =
        (document.querySelectorAll('#dewasa-wrapper .card').length * (harga.dewasa ?? 0)) +
        (document.querySelectorAll('#anak-wrapper .card').length * (harga.anak ?? 0)) +
        (document.querySelectorAll('#bayi-wrapper .card').length * (harga.bayi ?? 0));

    document.getElementById('grand-total').innerText = total.toLocaleString('id-ID');
}

tambahForm('dewasa');
</script>
@endsection
