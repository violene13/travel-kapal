@extends('layouts.admintravel')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="container mt-4">

  <h2 class="fw-bold text-primary mb-4">Detail Pemesanan</h2>

  {{-- INFO PEMESAN --}}
  <div class="card shadow-sm mb-4">
    <div class="card-body">

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">ID Pemesanan</div>
        <div class="col-md-8">
          #{{ str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Pemesan</div>
        <div class="col-md-8">
          {{ optional($pemesanan->penumpang)->nama_penumpang ?? '-' }}
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">No HP</div>
        <div class="col-md-8">
          {{ optional($pemesanan->penumpang)->no_hp ?? '-' }}
        </div>
      </div>

      <hr>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Rute</div>
        <div class="col-md-8">
          {{ optional(optional($pemesanan->jadwal)->jalur)->rute ?? '-' }}
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Kapal</div>
        <div class="col-md-8">
          {{ optional(optional($pemesanan->jadwal)->kapal)->nama_kapal ?? '-' }}
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Tanggal Berangkat</div>
        <div class="col-md-8">
          {{ optional($pemesanan->jadwal)?->tanggal_berangkat
            ? \Carbon\Carbon::parse($pemesanan->jadwal->tanggal_berangkat)->translatedFormat('d M Y')
            : '-' }}
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Status</div>
        <div class="col-md-8">
          <span class="badge
            @if($pemesanan->status=='Confirmed') bg-success
            @elseif($pemesanan->status=='Cancelled') bg-danger
            @else bg-warning text-dark @endif">
            {{ $pemesanan->status }}
          </span>
        </div>
      </div>

    </div>
  </div>

  {{-- DETAIL PENUMPANG --}}
  <div class="card shadow-sm mb-4">
    <div class="card-header fw-semibold">
      Rincian Penumpang
    </div>

    <div class="card-body p-0">
      <table class="table table-bordered mb-0">
        <thead class="table-light">
          <tr>
            <th>Nama</th>
            <th>Jenis Tiket</th>
            <th>Kelas</th>
            <th class="text-end">Harga</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pemesanan->detailPenumpang as $dp)
          <tr>
            <td>{{ $dp->nama_lengkap }}</td>
            <td>{{ ucfirst($dp->jenis_tiket) }}</td>
            <td>{{ ucfirst($dp->kelas) }}</td>
            <td class="text-end">
              Rp {{ number_format($dp->harga, 0, ',', '.') }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- TOTAL --}}
  <div class="card shadow-sm">
    <div class="card-body text-end">
      <h5 class="fw-bold">
        Total Harga :
        <span class="text-success">
          Rp {{ number_format($pemesanan->total_harga ?? 0, 0, ',', '.') }}
        </span>
      </h5>
    </div>
  </div>

  <div class="mt-3 text-end">
    <a href="{{ route('pemesanan.pemesanantravel.index') }}" class="btn btn-secondary">
      Kembali
    </a>
  </div>

</div>
@endsection
