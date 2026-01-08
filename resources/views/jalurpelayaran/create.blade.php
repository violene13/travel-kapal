@extends('layouts.adminpelayaran')

@section('title', 'Tambah Jalur Pelayaran')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Tambah Jalur Pelayaran</h4>

    <div class="card shadow-sm border-0 p-4">
        <form action="{{ route('jalurpelayaran.store') }}" method="POST" id="formSimpan">
            @csrf

            <div class="mb-3">
                <label class="form-label">Lokasi Asal</label>
                <select name="id_pelabuhan_asal" class="form-select @error('id_pelabuhan_asal') is-invalid @enderror" required>
                    <option value="">-- Pilih Lokasi Asal --</option>
                    @foreach ($pelabuhan as $p)
                        <option value="{{ $p->id_pelabuhan }}" {{ old('id_pelabuhan_asal') == $p->id_pelabuhan ? 'selected' : '' }}>
                            {{ $p->lokasi}}
                        </option>
                    @endforeach
                </select>
                @error('id_pelabuhan_asal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi Tujuan</label>
                <select name="id_pelabuhan_tujuan" class="form-select @error('id_pelabuhan_tujuan') is-invalid @enderror" required>
                    <option value="">-- Pilih Lokasi Tujuan --</option>
                    @foreach ($pelabuhan as $p)
                        <option value="{{ $p->id_pelabuhan }}" {{ old('id_pelabuhan_tujuan') == $p->id_pelabuhan ? 'selected' : '' }}>
                            {{ $p->lokasi }}
                        </option>
                    @endforeach
                </select>
                @error('id_pelabuhan_tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Durasi</label>
                <input type="text" name="durasi" class="form-control @error('durasi') is-invalid @enderror" value="{{ old('durasi') }}" placeholder="cth: 3 jam" required>
                @error('durasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Jarak (mil laut / km)</label>
                <input type="number" name="jarak" class="form-control @error('jarak') is-invalid @enderror" value="{{ old('jarak') }}" placeholder="cth: 120" required>
                @error('jarak')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary" id="btnSimpan">  Simpan</button>
                <a href="{{ route('jalurpelayaran.index') }}" class="btn btn-secondary px-4">Kembali</a>
            </div>
        </form>
    </div>
</div>
</script>
<script>
document.getElementById('btnSimpan').addEventListener('click', function (e) {
    e.preventDefault(); 

    Swal.fire({
        title: 'Yakin menyimpan data?',
        text: 'Pastikan data jalur sudah benar',
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
