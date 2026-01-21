@extends('layouts.adminpelayaran')

@section('title', 'Edit Jadwal Pelayaran')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Jadwal Pelayaran</h4>

    <form action="{{ route('jadwalpelayaran.update', $jadwal->id_jadwal) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- JALUR --}}
        <div class="mb-3">
            <label class="form-label">Jalur Pelayaran</label>
            <select name="id_jalur" class="form-select" required>
                <option value="">Pilih Jalur</option>
                @foreach ($jalur as $item)
                    <option value="{{ $item->id_jalur }}"
                        {{ $jadwal->id_jalur == $item->id_jalur ? 'selected' : '' }}>
                        {{ $item->pelabuhanAsal->lokasi ?? '-' }}
                        →
                        {{ $item->pelabuhanTujuan->lokasi ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- KAPAL --}}
        <div class="mb-3">
            <label class="form-label">Nama Kapal</label>
            <select name="id_kapal" class="form-select" required>
                <option value="">Pilih Kapal</option>
                @foreach ($kapal as $k)
                    <option value="{{ $k->id_kapal }}"
                        {{ $jadwal->id_kapal == $k->id_kapal ? 'selected' : '' }}>
                        {{ $k->nama_kapal }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TANGGAL --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Berangkat</label>
                <input type="date"
                       name="tanggal_berangkat"
                       class="form-control"
                       value="{{ $jadwal->tanggal_berangkat }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Tiba</label>
                <input type="date"
                       name="tanggal_tiba"
                       class="form-control"
                       value="{{ $jadwal->tanggal_tiba }}">
            </div>
        </div>

        {{-- JAM --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Berangkat</label>
                <input type="time"
                       name="jam_berangkat"
                       class="form-control"
                       value="{{ $jadwal->jam_berangkat }}"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Tiba</label>
                <input type="time"
                       name="jam_tiba"
                       class="form-control"
                       value="{{ $jadwal->jam_tiba }}"
                       required>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                Simpan Perubahan
            </button>
            <a href="{{ route('jadwalpelayaran.index') }}"
               class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
