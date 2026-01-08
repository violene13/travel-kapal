@extends('layouts.adminpelayaran')

@section('title', 'Edit Harga Tiket')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Edit Harga Tiket</h4>

    <div class="card p-3 shadow-sm">
        <form action="{{ route('ticketing.update', $groupKey) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- KAPAL --}}
            <div class="mb-3">
                <label class="form-label">Nama Kapal</label>
                <select name="id_kapal" class="form-select" required>
                    @foreach($kapals as $kapal)
                        <option value="{{ $kapal->id_kapal }}"
                            {{ $kapal->id_kapal == $id_kapal ? 'selected' : '' }}>
                            {{ $kapal->nama_kapal }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JALUR --}}
            <div class="mb-3">
                <label class="form-label">Rute Pelayaran</label>
                <select name="id_jalur" class="form-select" required>
                    @foreach($jalurs as $jalur)
                        <option value="{{ $jalur->id_jalur }}"
                            {{ $jalur->id_jalur == $id_jalur ? 'selected' : '' }}>
                            {{ $jalur->pelabuhanAsal->lokasi }}
                            →
                            {{ $jalur->pelabuhanTujuan->lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- KELAS --}}
            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control"
                       value="{{ $kelas }}" readonly>
            </div>

            {{-- KATEGORI & HARGA --}}
            <div class="mb-3">
                <label class="form-label">Kategori & Harga</label>

                @php
                    $map = $ticketings->keyBy('jenis_tiket');
                @endphp

               @foreach(['Dewasa','Anak','Bayi'] as $jenis)
<div class="col-md-4 mb-3">
    <label class="form-label">{{ $jenis }}</label>

    <input type="number"
           name="harga[{{ $jenis }}]"
           class="form-control"
           value="{{ old('harga.'.$jenis, $ticketings[$jenis]->harga ?? '') }}"
           placeholder="Kosongkan jika tidak ada">
</div>
@endforeach

                </div>
            </div>

            {{-- AKSI --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('ticketing.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
