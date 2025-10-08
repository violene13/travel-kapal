@extends('layouts.app')

@section('title', 'Edit Pemesanan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Pesanan</h2>

    <form action="{{ route('pemesanan.update', $pemesanan->id_pemesanan) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Pilih Jadwal --}}
        <div class="mb-3">
            <label for="jadwal_id" class="form-label">Jadwal Pelayaran</label>
            <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id_jadwal }}" 
                        {{ $jadwal->id_jadwal == $pemesanan->id_jadwal ? 'selected' : '' }}>
                        {{ $jadwal->kapal->nama_kapal ?? '-' }} | 
                        {{ $jadwal->jalur->asal->lokasi ?? '-' }} → {{ $jadwal->jalur->tujuan->lokasi ?? '-' }} 
                        ({{ $jadwal->tanggal_berangkat }} - {{ $jadwal->jam_berangkat }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Penumpang --}}
        <div class="mb-3">
            <label class="form-label">Nama Penumpang</label>
            <input type="text" class="form-control" value="{{ $pemesanan->penumpang->nama_penumpang }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" class="form-control" value="{{ $pemesanan->penumpang->no_hp }}" disabled>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status_pemesanan" class="form-label">Status Pemesanan</label>
            <select name="status_pemesanan" id="status_pemesanan" class="form-select" required>
                @foreach($statusList as $status)
                    <option value="{{ $status }}" {{ $status == $pemesanan->status_pemesanan ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
