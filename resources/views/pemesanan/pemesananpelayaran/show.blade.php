@extends('layouts.adminpelayaran')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="container mt-4">

<h3 class="fw-bold text-primary mb-3">Detail Pemesanan</h3>

<div class="card shadow-sm">
<div class="card-body">

<p>
    <b>ID Pesanan:</b>
    #{{ str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}
</p>

<p>
    <b>Pemesan:</b>
    {{ optional($pemesanan->penumpang)->nama_penumpang ?? '-' }}
</p>

<p>
    <b>No HP:</b>
    {{ optional($pemesanan->penumpang)->no_hp ?? '-' }}
</p>

<hr>

<h5 class="fw-bold">Daftar Penumpang</h5>

@if ($pemesanan->detailPenumpang->count())
   <ul class="list-group mb-3">
@foreach($pemesanan->detailPenumpang as $dp)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <div class="fw-semibold">{{ $dp->nama_lengkap }}</div>
            <small class="text-muted">
                Kategori : {{ ucfirst($dp->jenis_tiket ?? '-') }}
            </small>
        </div>
        <span class="badge bg-secondary">
            {{ ucfirst($dp->kelas) }}
        </span>
    </li>
@endforeach
</ul>

@else
    <p class="text-muted">Tidak ada data penumpang</p>
@endif

<hr>

<p>
    <b>Rute:</b>
    {{ optional(optional($pemesanan->jadwal)->jalur)->rute ?? '-' }}
</p>

<p>
    <b>Kapal:</b>
    {{ optional(optional($pemesanan->jadwal)->kapal)->nama_kapal ?? '-' }}
</p>

<p>
    <b>Tanggal:</b>
    @if(optional($pemesanan->jadwal)->tanggal_berangkat)
        {{ \Carbon\Carbon::parse($pemesanan->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}
    @else
        -
    @endif
</p>

<hr>

<h5 class="text-success">
    Total Harga:
    Rp {{ number_format($pemesanan->total_harga ?? 0, 0, ',', '.') }}
</h5>

<p>
    Status:
    @if($pemesanan->status === 'Confirmed')
        <span class="badge bg-success">Confirmed</span>
    @elseif($pemesanan->status === 'Cancelled')
        <span class="badge bg-danger">Cancelled</span>
    @else
        <span class="badge bg-warning text-dark">Pending</span>
    @endif
</p>

</div>
</div>

<a href="{{ route('pemesanan.pemesananpelayaran.index') }}"
   class="btn btn-secondary mt-3">
    Kembali
</a>

</div>
@endsection
