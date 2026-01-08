@extends('layouts.pengguna')

@section('content')
<div class="container py-4">

<h4 class="mb-3">Pembayaran</h4>

<div class="card mb-3">
    <div class="card-header fw-bold">
        Ringkasan Pemesanan
    </div>
    <div class="card-body">

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Nama Penumpang</th>
                    <th>Jenis Tiket</th>
                    <th class="text-end">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemesanan->detailPenumpang as $penumpang)
                <tr>
                    <td>{{ $penumpang->id_penumpang }}</td>
                    <td>{{ ucfirst($penumpang->jenis_tiket) }}</td>
                    <td class="text-end">
                        Rp {{ number_format($penumpang->harga, 0, ',', '.') }}
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

<div class="card">
    <div class="card-header fw-bold">
        Metode Pembayaran
    </div>
    <div class="card-body">

        <form action="#" method="POST">
            @csrf

            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="metode" checked>
                <label class="form-check-label">
                    Transfer Bank
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="metode">
                <label class="form-check-label">
                    E-Wallet
                </label>
            </div>

            <button class="btn btn-success w-100 fw-bold">
                Bayar Sekarang
            </button>
        </form>

    </div>
</div>

</div>
@endsection
