@extends('layouts.admintravel')
@section('title', 'Tambah Penumpang')

@section('content')
<div class="container">
    <h1 class="mb-4 text-primary fw-bold">Tambah Penumpang</h1>

    <div class="card shadow-sm p-4 border-0">
        <form action="{{ route('penumpang.penumpangtravel.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama_penumpang" class="form-label">Nama Penumpang</label>
                    <input type="text" name="nama_penumpang" id="nama_penumpang" 
                           class="form-control @error('nama_penumpang') is-invalid @enderror"
                           value="{{ old('nama_penumpang') }}" required>
                    @error('nama_penumpang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" 
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" 
                           class="form-control @error('no_hp') is-invalid @enderror"
                           value="{{ old('no_hp') }}">
                    @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" 
                           class="form-control @error('alamat') is-invalid @enderror"
                           value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="no_ktp" class="form-label">No KTP</label>
                    <input type="text" name="no_ktp" id="no_ktp" 
                           class="form-control @error('no_ktp') is-invalid @enderror"
                           value="{{ old('no_ktp') }}">
                    @error('no_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">-- Pilih Gender --</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                           class="form-control @error('tanggal_lahir') is-invalid @enderror"
                           value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('penumpang.penumpangtravel.index') }}" class="btn btn-secondary px-4">
                  Kembali
                </a>
                <button type="submit" class="btn btn-success px-4">
                   Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
