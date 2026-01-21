@extends('layouts.pengguna')

@section('content')
<div class="container py-4">

    <h4 class="fw-bold mb-4">Detail Pemesanan</h4>

    {{-- ALERT SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD PEMESANAN --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Kode Pemesanan</span>
                <span class="fw-bold">#{{ $pemesanan->id_pemesanan }}</span>
            </div>

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Tanggal Pesan</span>
                <span>
                    {{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->format('d M Y H:i') }}
                </span>
            </div>

            <div class="d-flex justify-content-between">
                <span class="text-muted">Status</span>
                <span>
                    @if ($pemesanan->status === 'Pending')
                        <span class="badge bg-warning text-dark px-3">Pending</span>
                   @elseif ($pemesanan->status === 'Confirmed')
                        <span class="badge bg-success px-3">Confirmed</span>
                    @elseif ($pemesanan->status === 'Cancelled')
                        <span class="badge bg-danger px-3">Cancelled</span>
                    @else
                        <span class="badge bg-secondary px-3">
                            {{ $pemesanan->status }}
                        </span>
                    @endif
                </span>
            </div>

        </div>
    </div>
    {{-- DAFTAR PENUMPANG --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        Daftar Penumpang
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Penumpang</th>
                    <th>Kategori</th>
                    <th>Kelas</th>
                    <th class="text-end">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemesanan->detailPenumpang as $i => $dp)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $dp->nama_lengkap }}</td>
                        <td class="text-capitalize">{{ $dp->jenis_tiket }}</td>
                        <td class="text-capitalize">{{ $dp->kelas }}</td>
                        <td class="text-end">
                            Rp {{ number_format($dp->harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


    {{-- INFORMASI PELAYARAN --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold">
            Informasi Pelayaran
        </div>
        <div class="card-body">

            <div class="mb-3">
                <span class="fw-semibold">🚢 Kapal</span><br>
                <span class="text-muted">
                    {{ optional($pemesanan->jadwal->kapal)->nama_kapal ?? '-' }}
                </span>
            </div>

            <div class="mb-3">
                <span class="fw-semibold">🗺️ Rute</span><br>
                <span class="text-muted">
                    {{ optional($pemesanan->jadwal->jalur->pelabuhanAsal)->lokasi ?? '-' }}
                    →
                    {{ optional($pemesanan->jadwal->jalur->pelabuhanTujuan)->lokasi ?? '-' }}
                </span>
            </div>

            <div class="mb-3">
                <span class="fw-semibold">📅 Tanggal Berangkat</span><br>
                <span class="text-muted">
                    {{ \Carbon\Carbon::parse($pemesanan->jadwal->tanggal_berangkat)->format('d M Y') }}
                </span>
            </div>

            <div>
                <span class="fw-semibold">⏰ Jam Berangkat</span><br>
                <span class="text-muted">
                    {{ substr($pemesanan->jadwal->jam_berangkat, 0, 5) }}
                </span>
            </div>

        </div>
    </div>

    {{-- TOTAL HARGA --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <span class="fw-bold fs-5">Total Harga</span>
            <span class="fw-bold fs-5 text-primary">
                Rp {{ number_format((int)$pemesanan->total_harga, 0, ',', '.') }}
            </span>
        </div>
    </div>

    {{-- AKSI --}}
    <div class="d-flex flex-column align-items-center gap-2">

        @if ($pemesanan->status === 'Pending')
            <a href="{{ route('pembayaran.show', $pemesanan->id_pemesanan) }}"
               class="btn btn-primary fw-bold px-4">
                Bayar Sekarang
            </a>
        @else
            <button class="btn btn-success fw-bold px-4" disabled>
                Sudah Dibayar
            </button>
        @endif

        <a href="{{ route('pemesanan.pemesananpengguna.create', $pemesanan->id_jadwal) }}"
           class="btn btn-outline-secondary fw-bold px-4">
            Kembali
        </a>

    </div>

</div>
@endsection
