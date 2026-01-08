@extends('layouts.admintravel')
@section('title', 'Edit Data Penumpang')

@section('content')
<div class="container">
    <h1 class="mb-4 text-dark">Edit Data Penumpang</h1>

    <div class="card shadow-sm p-4">
        <form action="{{ route('penumpang.penumpangtravel.update', $penumpang->id_penumpang) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama_penumpang" class="form-label">Nama Penumpang</label>
                    <input type="text" name="nama_penumpang" id="nama_penumpang" class="form-control"
                        value="{{ old('nama_penumpang', $penumpang->nama_penumpang) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ old('email', $penumpang->email) }}" required>
                </div>

                <div class="col-md-6">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control"
                        value="{{ old('no_hp', $penumpang->no_hp) }}">
                </div>

                <div class="col-md-6">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control"
                        value="{{ old('alamat', $penumpang->alamat) }}">
                </div>

                <div class="col-md-6">
                    <label for="no_ktp" class="form-label">No KTP</label>
                    <input type="text" name="no_ktp" id="no_ktp" class="form-control"
                        value="{{ old('no_ktp', $penumpang->no_ktp) }}">
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="L" {{ old('gender', $penumpang->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $penumpang->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>

                </div>
                

                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                        value="{{ old('tanggal_lahir', $penumpang->tanggal_lahir) }}">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('penumpang.penumpangtravel.index') }}" class="btn btn-secondary px-4">Kembali</a>
                <button type="submit" class="btn btn-success px-4">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
