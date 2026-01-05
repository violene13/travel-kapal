@extends('layouts.adminpelayaran')

@section('title', 'Edit Jalur Pelayaran')

@section('content')
<div class="container mt-4">
    <h4>Edit Jalur Pelayaran</h4>
    <div class="card p-3 mt-3 shadow-sm">
        <form action="{{ route('jalurpelayaran.update', $jalur->id_jalur) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pilih Pelabuhan Asal --}}
            <div class="mb-3">
                <label class="form-label">Lokasi Asal</label>
                <select name="id_pelabuhan_asal" class="form-select" required>
                    <option value="">-- Pilih Lokasi Asal --</option>
                    @foreach ($pelabuhan as $p)
                        <option value="{{ $p->id_pelabuhan }}" 
                            {{ $jalur->id_pelabuhan_asal == $p->id_pelabuhan ? 'selected' : '' }}>
                            {{ $p->lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Pelabuhan Tujuan --}}
            <div class="mb-3">
                <label class="form-label">Lokasi Tujuan</label>
                <select name="id_pelabuhan_tujuan" class="form-select" required>
                    <option value="">-- Pilih Lokasi Tujuan --</option>
                    @foreach ($pelabuhan as $p)
                        <option value="{{ $p->id_pelabuhan }}" 
                            {{ $jalur->id_pelabuhan_tujuan == $p->id_pelabuhan ? 'selected' : '' }}>
                            {{ $p->lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Durasi --}}
            <div class="mb-3">
                <label class="form-label">Durasi</label>
                <input type="text" name="durasi" class="form-control" value="{{ $jalur->durasi }}" required>
            </div>

            {{-- Jarak --}}
            <div class="mb-3">
                <label class="form-label">Jarak (mil laut / km)</label>
                <input type="number" name="jarak" class="form-control" value="{{ $jalur->jarak }}" required>
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('jalurpelayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
