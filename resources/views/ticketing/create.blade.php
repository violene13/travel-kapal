@extends('layouts.adminpelayaran')

@section('title', 'Tambah Harga Tiket')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Tambah Harga Tiket</h4>

    <div class="card p-3 shadow-sm">
        <form action="{{ route('ticketing.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="id_kapal" class="form-label">Nama Kapal</label>
              <select name="id_kapal" id="id_kapal" class="form-select" required>
    <option value="">-- Pilih Kapal --</option>
    @foreach($kapals as $kapal)
        <option value="{{ $kapal->id_kapal }}">{{ $kapal->nama_kapal }}</option>
    @endforeach
</select>
            </div>

            <div class="mb-3">
                <label for="id_jalur" class="form-label">Rute Pelayaran</label>
                <select name="id_jalur" id="id_jalur" class="form-select" required>
                    <option value="">-- Pilih Jalur --</option>
                    @foreach($jalurs as $jalur)
                        <option value="{{ $jalur->id_jalur }}">
                            {{ $jalur->pelabuhanAsal->lokasi }} → {{ $jalur->pelabuhanTujuan->lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Penumpang</label>
                <select name="jenis_tiket" class="form-select" required>
                    <option value="">-- Pilih Jenis Penumpang --</option>
                    <option value="Dewasa">Dewasa</option>
                    <option value="Anak">Anak-anak</option>
                    <option value="Bayi">Bayi</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Masukkan kelas tiket" required>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan harga tiket" required>
            </div>

             <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('ticketing.index') }}" class="btn btn-secondary">Kembali</a>
                
           
        </form>
    </div>
</div>
@endsection
