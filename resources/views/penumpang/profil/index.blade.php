@extends('layouts.pengguna')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profil Saya</h5>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('penumpang.profil.update') }}"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        @php
                            if ($penumpang->foto && file_exists(public_path('storage/' . $penumpang->foto))) {
                                $fotoUrl = asset('storage/' . $penumpang->foto);
                            } else {
                                $fotoUrl = asset('images/default-avatar.png');
                            }
                        @endphp

                        <div class="text-center mb-4">
                            <img
                                src="{{ $fotoUrl }}"
                                class="rounded-circle mb-2"
                                width="120"
                                height="120"
                                style="object-fit: cover;"
                                id="previewFoto"
                                alt="Foto Profil"
                            >

                            <div class="mt-2">
                                <input type="file"
                                       name="foto"
                                       class="form-control @error('foto') is-invalid @enderror"
                                       accept="image/*"
                                       onchange="previewImage(this)">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- NAMA --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text"
                                   name="nama_penumpang"
                                   class="form-control @error('nama_penumpang') is-invalid @enderror"
                                   value="{{ old('nama_penumpang', $penumpang->nama_penumpang) }}">
                            @error('nama_penumpang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   class="form-control"
                                   value="{{ $penumpang->email }}"
                                   readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="{{ old('no_hp', $penumpang->no_hp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat"
                                      class="form-control"
                                      rows="3">{{ old('alamat', $penumpang->alamat) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- PREVIEW FOTO --}}
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewFoto').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
