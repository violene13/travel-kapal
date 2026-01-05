@extends('layouts.admintravel')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="container mt-4">
  <h2 class="fw-bold text-primary mb-4">Detail Pemesanan</h2>

  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
      {{-- Informasi Pemesanan --}}
      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">ID Pemesanan:</div>
        <div class="col-md-8">#{{ str_pad($pemesanan->id_pemesanan, 5, '0', STR_PAD_LEFT) }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">No KTP:</div>
        <div class="col-md-8">{{ optional($pemesanan->penumpang)->no_ktp ?? '-' }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Nama Penumpang:</div>
        <div class="col-md-8">{{ optional($pemesanan->penumpang)->nama_penumpang ?? '-' }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Jenis Kelamin:</div>
        <div class="col-md-8">
          @php
            $gender = optional($pemesanan->penumpang)->gender;
          @endphp
          @if($gender === 'L')
            Laki-laki
          @elseif($gender === 'P')
            Perempuan
          @else
            -
          @endif
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">No HP:</div>
        <div class="col-md-8">{{ optional($pemesanan->penumpang)->no_hp ?? '-' }}</div>
      </div>

      <hr>

      {{-- Informasi Jadwal --}}
      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Rute:</div>
        <div class="col-md-8">{{ optional(optional($pemesanan->jadwal)->jalur)->rute ?? '-' }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Kapal:</div>
        <div class="col-md-8">{{ optional(optional($pemesanan->jadwal)->kapal)->nama_kapal ?? '-' }}</div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Tanggal Keberangkatan:</div>
        <div class="col-md-8">
          @if(optional($pemesanan->jadwal)->tanggal_berangkat)
            {{ \Carbon\Carbon::parse($pemesanan->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}
          @else
            -
          @endif
        </div>
      </div>

      <div class="row mb-2">
        <div class="col-md-4 fw-semibold">Status:</div>
        <div class="col-md-8">
          @php $status = strtolower($pemesanan->status ?? 'pending'); @endphp
          @if($status === 'confirmed')
            <span class="badge bg-success">Confirmed</span>
          @elseif($status === 'cancelled')
            <span class="badge bg-danger">Cancelled</span>
          @else
            <span class="badge bg-warning text-dark">Pending</span>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="mt-3 text-end">
    <a href="{{ route('pemesanan.pemesanantravel.index') }}" class="btn btn-secondary">
       Kembali
    </a>
  </div>
</div>
@endsection
