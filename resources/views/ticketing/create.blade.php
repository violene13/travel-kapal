@extends('layouts.adminpelayaran')

@section('title', 'Tambah Harga Tiket')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Tambah Harga Tiket</h4>

    <div class="card p-3 shadow-sm">
        <form action="{{ route('ticketing.store') }}" method="POST">
            @csrf

            {{-- KAPAL --}}
            <div class="mb-3">
                <label class="form-label">Nama Kapal</label>
                <select name="id_kapal" class="form-select" required>
                    <option value="">-- Pilih Kapal --</option>
                    @foreach($kapals as $kapal)
                        <option value="{{ $kapal->id_kapal }}">
                            {{ $kapal->nama_kapal }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JALUR --}}
            <div class="mb-3">
                <label class="form-label">Rute Pelayaran</label>
                <select name="id_jalur" class="form-select" required>
                    <option value="">-- Pilih Jalur --</option>
                    @foreach($jalurs as $jalur)
                        <option value="{{ $jalur->id_jalur }}">
                            {{ $jalur->pelabuhanAsal->lokasi }}
                            →
                            {{ $jalur->pelabuhanTujuan->lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- KELAS --}}
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    <option value="Ekonomi">Ekonomi</option>
                    <option value="Bisnis">Bisnis</option>
                    <option value="VIP">VIP</option>
                </select>
            </div>

            <hr>

            <h6 class="mb-3">Kategori & Harga Tiket</h6>

            {{-- DEWASA --}}
            <div class="row mb-2 align-items-center">
                <div class="col-md-3">
                    <span class="badge text-bg-primary">Dewasa</span>
                </div>
                <div class="col-md-6">
                    <input type="number"
                           name="harga[Dewasa]"
                           class="form-control"
                           placeholder="Harga Dewasa (Rp)">
                </div>
            </div>

            {{-- ANAK --}}
            <div class="row mb-2 align-items-center">
                <div class="col-md-3">
                    <span class="badge text-bg-warning">Anak</span>
                </div>
                <div class="col-md-6">
                    <input type="number"
                           name="harga[Anak]"
                           class="form-control"
                           placeholder="Harga Anak (Rp)">
                </div>
            </div>

            {{-- BAYI --}}
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <span class="badge text-bg-secondary">Bayi</span>
                </div>
                <div class="col-md-6">
                    <input type="number"
                           name="harga[Bayi]"
                           class="form-control"
                           placeholder="Harga Bayi (Rp)">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    Simpan
                </button>
                <a href="{{ route('ticketing.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
