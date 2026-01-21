@extends('layouts.pengguna')

@section('content')
<div class="container py-4">

<h4 class="mb-3">Pembayaran</h4>

<div class="card mb-3">
    <div class="card-header fw-bold">Ringkasan Pemesanan</div>
    <div class="card-body">

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Nama Penumpang</th>
                    <th>Kategori</th>
                    <th class="text-end">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penumpang as $p)
                <tr>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ ucfirst($p->jenis_tiket) }}</td>
                    <td class="text-end">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <div class="d-flex justify-content-between fw-bold">
            <span>Total Bayar</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

<form action="{{ route('pembayaran.proses', $pemesanan->id_pemesanan) }}" method="POST">
@csrf

<div class="card">
    <div class="card-header fw-bold">Metode Pembayaran</div>
    <div class="card-body">
        @foreach ($metodePembayaran as $m)
        <div class="form-check mb-2">
            <input
                class="form-check-input"
                type="radio"
                name="id_metode"
                value="{{ $m->id_metode }}"
                id="metode{{ $m->id_metode }}"
                required
            >
            <label class="form-check-label" for="metode{{ $m->id_metode }}">
                <strong>{{ $m->nama_metode }}</strong><br>
                <small class="text-muted">{{ $m->keterangan }}</small>
            </label>
        </div>
        @endforeach
    </div>
</div>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-success fw-bold px-4">
        Bayar Sekarang
    </button>
</div>

<div class="text-center mt-3">
    <a href="{{ route('pemesanan.pemesananpengguna.index') }}"
   class="btn btn-outline-danger fw-bold">
    Batal
</a>

</div>

</form>

</div>
@endsection
