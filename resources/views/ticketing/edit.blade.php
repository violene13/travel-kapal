@extends('layouts.adminpelayaran')

@section('title', 'Edit Harga Tiket')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Edit Harga Tiket</h4>

    <div class="card p-3 shadow-sm">
        <form action="{{ route('ticketing.update', $ticketing->id_ticketing) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="id_kapal" class="form-label">Nama Kapal</label>
        <select name="id_kapal" id="id_kapal" class="form-select" required>
            @foreach($kapals as $kapal)
                <option value="{{ $kapal->id_kapal }}" {{ $kapal->id_kapal == $ticketing->id_kapal ? 'selected' : '' }}>
                    {{ $kapal->nama_kapal }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="id_jalur" class="form-label">Rute Pelayaran</label>
        <select name="id_jalur" id="id_jalur" class="form-select" required>
            @foreach($jalurs as $jalur)
                <option value="{{ $jalur->id_jalur }}" {{ $jalur->id_jalur == $ticketing->id_jalur ? 'selected' : '' }}>
                    {{ $jalur->pelabuhanAsal->nama_pelabuhan }} → {{ $jalur->pelabuhanTujuan->nama_pelabuhan }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
    <label for="jenis_tiket" class="form-label">Jenis Tiket</label>
    <select 
        name="jenis_tiket" 
        id="jenis_tiket" 
        class="form-select @error('jenis_tiket') is-invalid @enderror" 
        required
    >
        <option value="">-- Pilih Jenis Tiket --</option>

        <option value="Dewasa" 
            {{ old('jenis_tiket', $ticketing->jenis_tiket) == 'Dewasa' ? 'selected' : '' }}>
            Dewasa
        </option>

        <option value="Anak" 
            {{ old('jenis_tiket', $ticketing->jenis_tiket) == 'Anak' ? 'selected' : '' }}>
            Anak
        </option>

        <option value="Bayi" 
            {{ old('jenis_tiket', $ticketing->jenis_tiket) == 'Bayi' ? 'selected' : '' }}>
            Bayi
        </option>
    </select>

    @error('jenis_tiket')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


    <div class="mb-3">
        <label for="kelas" class="form-label">Kelas</label>
        <input type="text" name="kelas" id="kelas" class="form-control" value="{{ $ticketing->kelas }}" required>
    </div>

    <div class="mb-3">
        <label for="harga" class="form-label">Harga (Rp)</label>
        <input type="number" name="harga" id="harga" class="form-control" value="{{ $ticketing->harga }}" required>
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('ticketing.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </div>
</form>

    </div>
</div>
@endsection
