@extends('layouts.admintravel')

@section('title', 'Tambah Pemesanan Travel')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mb-4">Tambah Pemesanan Travel</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('pemesanan.pemesanantravel.store') }}" method="POST">
        @csrf

        {{-- ================= PEMESAN UTAMA ================= --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Pemesan Utama</h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text"
                               name="pemesan[nama_penumpang]"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">No HP</label>
                        <input type="text"
                               name="pemesan[no_hp]"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">No KTP</label>
                        <input type="text"
                               name="pemesan[no_ktp]"
                               class="form-control">
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= JADWAL ================= --}}
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Jadwal Pelayaran</h5>

                <select name="id_jadwal" class="form-select" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($jadwals as $j)
                        <option value="{{ $j->id_jadwal }}">
                            {{ $j->kapal->nama_kapal }} |
                            {{ $j->jalur->rute }} |
                            {{ \Carbon\Carbon::parse($j->tanggal_berangkat)->format('d M Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- ================= PENUMPANG ================= --}}
        @foreach (['dewasa','anak','bayi'] as $tipe)
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold text-capitalize mb-0">{{ $tipe }}</h5>
                    <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            onclick="addPenumpang('{{ $tipe }}')">
                        + Tambah
                    </button>
                </div>

                <div id="{{ $tipe }}Wrapper"></div>
            </div>
        </div>
        @endforeach

        <div class="text-end">
            <a href="{{ route('pemesanan.pemesanantravel.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                Simpan Pemesanan
            </button>
        </div>
    </form>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
const kelasTiket = @json($kelasTiket);
const TAHUN_ACUAN = 2026;

/* ---------- OPSI TANGGAL ---------- */
function opsiTanggal() {
    let opt = '<option value="">Tgl</option>';
    for (let i = 1; i <= 31; i++) {
        opt += `<option value="${i}">${i}</option>`;
    }
    return opt;
}

/* ---------- OPSI BULAN ---------- */
function opsiBulan() {
    let opt = '<option value="">Bln</option>';
    for (let i = 1; i <= 12; i++) {
        opt += `<option value="${i}">${i}</option>`;
    }
    return opt;
}

/* ---------- OPSI TAHUN BERDASARKAN JENIS ---------- */
function opsiTahun(tipe) {
    let opt = '<option value="">Thn</option>';

    if (tipe === 'bayi') {
        for (let t = TAHUN_ACUAN; t >= TAHUN_ACUAN - 1; t--) {
            opt += `<option value="${t}">${t}</option>`;
        }
    }

    if (tipe === 'anak') {
        for (let t = TAHUN_ACUAN - 2; t >= TAHUN_ACUAN - 11; t--) {
            opt += `<option value="${t}">${t}</option>`;
        }
    }

    if (tipe === 'dewasa') {
        for (let t = TAHUN_ACUAN - 12; t >= 1925; t--) {
            opt += `<option value="${t}">${t}</option>`;
        }
    }

    return opt;
}

/* ---------- TAMBAH PENUMPANG ---------- */
function addPenumpang(tipe) {
    const wrapper = document.getElementById(tipe + 'Wrapper');

    let opsiKelas = '';
    kelasTiket.forEach(k => {
        opsiKelas += `<option value="${k.toLowerCase()}">${k}</option>`;
    });

    wrapper.insertAdjacentHTML('beforeend', `
        <div class="border rounded p-3 mb-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small">Nama Lengkap</label>
                    <input type="text"
                           name="${tipe}[][nama_lengkap]"
                           class="form-control"
                           required>
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Kelas</label>
                    <select name="${tipe}[][kelas]"
                            class="form-select"
                            required>
                        ${opsiKelas}
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="button"
                            class="btn btn-danger w-100"
                            onclick="this.closest('.border').remove()">
                        Hapus
                    </button>
                </div>
            </div>

            <div class="row g-2 mt-2">
                <div class="col">
                    <select name="${tipe}[][tanggal]"
                            class="form-select"
                            required>
                        ${opsiTanggal()}
                    </select>
                </div>
                <div class="col">
                    <select name="${tipe}[][bulan]"
                            class="form-select"
                            required>
                        ${opsiBulan()}
                    </select>
                </div>
                <div class="col">
                    <select name="${tipe}[][tahun]"
                            class="form-select"
                            required>
                        ${opsiTahun(tipe)}
                    </select>
                </div>
            </div>
        </div>
    `);
}
</script>
@endsection
