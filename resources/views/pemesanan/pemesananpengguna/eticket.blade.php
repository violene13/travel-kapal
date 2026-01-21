@extends('layouts.pengguna')

@section('title', 'E-Ticket')

@section('content')
<div class="container py-4" style="max-width: 900px">

<style>
.ticket-card {
    border-radius: 20px;
    overflow: hidden;
}
.ticket-header {
    background: linear-gradient(135deg, #198754, #157347);
    color: white;
}
.ticket-code {
    font-size: 1.6rem;
    letter-spacing: 4px;
    font-weight: 700;
}
.label {
    font-size: 0.75rem;
    color: #6c757d;
    text-transform: uppercase;
}
.qr-box {
    border: 2px dashed #ced4da;
    border-radius: 14px;
    padding: 12px;
    background: #fff;
}
.route-box {
    background: #f8f9fa;
    border-radius: 14px;
    padding: 20px;
}
@media print {
    .no-print { display: none; }
    body { background: white; }
}
</style>

<div class="card ticket-card shadow-lg">

    <!-- HEADER -->
    <div class="ticket-header p-4 text-center">
        <h4 class="fw-bold mb-0">E-TICKET PENYEBERANGAN</h4>
        <small class="opacity-75">Digital Boarding Pass</small>
    </div>

    <!-- BODY -->
    <div class="card-body p-4">

        <!-- KODE + QR -->
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <div class="label mb-1">Kode Pemesanan</div>
                <div class="ticket-code text-success">
                    #{{ $pemesanan->id_pemesanan }}
                </div>
                <span class="badge bg-success mt-2 px-3 py-2">CONFIRMED</span>
            </div>

            <div class="col-md-4 text-center mt-3 mt-md-0">
                <div class="qr-box d-inline-block">
                    <img 
                        src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data=ETICKET-{{ $pemesanan->id_pemesanan }}" 
                        class="img-fluid"
                    >
                    <div class="label mt-2">Boarding Code</div>
                </div>
            </div>
        </div>

        <!-- RUTE -->
        <div class="route-box text-center mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <div class="label">Asal</div>
                    <h6 class="fw-bold mb-0">
                        {{ $pemesanan->jadwal->jalur->pelabuhanAsal->lokasi }}
                    </h6>
                </div>

                <div class="col-auto">
                    <h3 class="text-success mb-0">→</h3>
                </div>

                <div class="col">
                    <div class="label">Tujuan</div>
                    <h6 class="fw-bold mb-0">
                        {{ $pemesanan->jadwal->jalur->pelabuhanTujuan->lokasi }}
                    </h6>
                </div>
            </div>
        </div>

        <!-- DETAIL -->
        <div class="row mb-4 text-center text-md-start">
            <div class="col-md-4">
                <div class="label">Kapal</div>
                <div class="fw-bold">
                    {{ $pemesanan->jadwal->kapal->nama_kapal }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="label">Tanggal Berangkat</div>
                <div class="fw-bold">
                    {{ \Carbon\Carbon::parse($pemesanan->jadwal->tanggal_berangkat)->format('d M Y') }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="label">Durasi</div>
                <div class="fw-bold">
                    {{ $pemesanan->jadwal->jalur->durasi }}
                </div>
            </div>
        </div>

        <hr>

        <!-- PENUMPANG -->
        <h6 class="fw-bold mb-3">Penumpang</h6>

        @foreach ($pemesanan->detailPenumpang as $p)
        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
            <div>
                <div class="fw-bold">{{ $p->nama_lengkap }}</div>
                <small class="text-muted">
                    {{ ucfirst($p->jenis_tiket) }} · {{ strtoupper($p->kelas) }}
                </small>
            </div>
            <div class="fw-bold text-success">
                Rp {{ number_format($p->harga, 0, ',', '.') }}
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-between fw-bold fs-6 mt-3">
            <span>Total Harga</span>
            <span class="text-success">
                Rp {{ number_format($pemesanan->detailPenumpang->sum('harga'), 0, ',', '.') }}
            </span>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="card-footer text-center no-print">
        <button onclick="window.print()" class="btn btn-success fw-bold px-4">
            Cetak / Simpan PDF
        </button>

        <a href="{{ route('pemesanan.pemesananpengguna.index') }}"
           class="btn btn-outline-secondary fw-bold ms-2">
            Kembali
        </a>
    </div>

</div>
</div>
@endsection
