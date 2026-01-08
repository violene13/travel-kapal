@extends('layouts.adminpelayaran')

@section('title', 'Edit Data Pelabuhan')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3 fw-bold text-primary">Edit Data Pelabuhan</h4>

    <div class="card p-4 shadow-sm rounded">
        <form action="{{ route('datapelabuhan.update', $pelabuhan->id_pelabuhan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Pelabuhan</label>
                <input type="text" 
                       name="nama_pelabuhan" 
                       value="{{ old('nama_pelabuhan', $pelabuhan->nama_pelabuhan) }}" 
                       class="form-control @error('nama_pelabuhan') is-invalid @enderror" 
                       required>
                @error('nama_pelabuhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Lokasi</label>
                <input type="text" 
                       name="lokasi" 
                       value="{{ old('lokasi', $pelabuhan->lokasi) }}" 
                       class="form-control @error('lokasi') is-invalid @enderror" 
                       required>
                @error('lokasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Fasilitas Pelabuhan</label>
                <textarea name="fasilitas_pelabuhan" 
                          class="form-control @error('fasilitas_pelabuhan') is-invalid @enderror" 
                          rows="3">{{ old('fasilitas_pelabuhan', $pelabuhan->fasilitas_pelabuhan) }}</textarea>
                @error('fasilitas_pelabuhan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('datapelabuhan.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    h4 {
        color: #003B5C;
    }
    .card {
        border: none;
        border-radius: 10px;
    }
</style>
@endsection
