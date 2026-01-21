@extends('layouts.adminpelayaran')

@section('title', 'Tambah Jadwal Pelayaran')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Jadwal Pelayaran</h4>

    <form action="{{ route('jadwalpelayaran.store') }}" method="POST">
        @csrf

        {{-- JALUR --}}
        <div class="mb-3">
            <label class="form-label">Jalur Pelayaran</label>
            <select name="id_jalur" class="form-select" required>
                <option value="">Pilih Jalur</option>
                @foreach ($jalur as $item)
                    <option value="{{ $item->id_jalur }}">
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
                    <option value="{{ $k->id_kapal }}">
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
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Tiba</label>
                <input type="date"
                       name="tanggal_tiba"
                       class="form-control">
            </div>
        </div>

        {{-- JAM --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Berangkat</label>
                <input type="time"
                       name="jam_berangkat"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Jam Tiba</label>
                <input type="time"
                       name="jam_tiba"
                       class="form-control"
                       required>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="mt-4">
            <button type="submit" class="btn btn-success">
                Simpan
            </button>
            <a href="{{ route('jadwalpelayaran.index') }}"
               class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
