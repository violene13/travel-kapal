@extends('layouts.adminpelayaran')

@section('content')
<div class="container mt-4">
    <h4>Tambah Pelabuhan</h4>
    <div class="card p-3 mt-3">
        <form action="{{ route('datapelabuhan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Pelabuhan</label>
                <input type="text" name="nama_pelabuhan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Fasilitas</label>
                <textarea name="fasilitas_pelabuhan" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('datapelabuhan.index') }}" class="btn btn-primary">Kembali</a>
        </form>
    </div>
</div>
@endsection
