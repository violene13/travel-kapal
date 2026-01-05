@extends('layouts.adminpelayaran')

@section('content')
<div class="container mt-4">
    <h4>Tambah Pelabuhan</h4>
    <div class="card p-3 mt-3">
        <form action="{{ route('datapelabuhan.store') }}" method="POST"id="formSimpan">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Pelabuhan</label>
                <input type="text" name="nama_pelabuhan" class="form-control @error('nama_pelabuhan') is-invalid @enderror" required>
                @error('nama_pelabuhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" required>
                @error('lokasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Fasilitas</label>
                <textarea name="fasilitas_pelabuhan" class="form-control @error('fasilitas_pelabuhan') is-invalid @enderror" required rows="3"> </textarea>
                @error('fasilitas_pelabuhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

           <button type="submit" class="btn btn-success" id="btnSimpan"> Simpan</button>
            <a href="{{ route('datapelabuhan.index') }}" class="btn btn-primary">Kembali</a>
        </form>
    </div>
</div>

<script>
document.getElementById('btnSimpan').addEventListener('click', function (e) {
    e.preventDefault(); // tahan submit dulu

    Swal.fire({
        title: 'Yakin menyimpan data?',
        text: 'Pastikan data pelabuhan sudah benar',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formSimpan').submit();
        }
    });
});
</script>
@endsection
