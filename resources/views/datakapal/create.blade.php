@extends('layouts.adminpelayaran')

@section('title', 'Tambah Kapal')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Tambah Kapal</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('datakapal.store') }}" method="POST"id="formSimpan">
                @csrf

                <div class="mb-3">
                    <label for="nama_kapal" class="form-label">Nama Kapal</label>
                    <input type="text" class="form-control @error('nama_kapal') is-invalid @enderror" 
                           id="nama_kapal" name="nama_kapal" value="{{ old('nama_kapal') }}" required>
                    @error('nama_kapal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jenis_kapal" class="form-label">Jenis Kapal</label>
                    <select name="jenis_kapal" id="jenis_kapal" class="form-control @error('jenis_kapal') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kapal --</option>
                        <option value="Penumpang" {{ old('jenis_kapal') == 'Penumpang' ? 'selected' : '' }}>Penumpang</option>
                        <option value="Barang" {{ old('jenis_kapal') == 'Barang' ? 'selected' : '' }}>Barang</option>
                        <option value="Lainnya" {{ old('jenis_kapal') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_kapal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <input type="number" class="form-control @error('kapasitas') is-invalid @enderror" 
                           id="kapasitas" name="kapasitas" value="{{ old('kapasitas') }}" required>
                    @error('kapasitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

             <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success" id="btnSimpan">Simpan</button>
                <a href="{{ route('datakapal.index') }}" class="btn btn-primary btn-sm">Kembali</a>
    
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('btnSimpan');
    const form = document.getElementById('formSimpan');

    btn.addEventListener('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Yakin menyimpan data?',
            text: 'Pastikan data Kapal sudah benar',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});
</script>

@endsection
