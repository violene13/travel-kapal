@extends('layouts.adminpelayaran')

@section('title', 'Edit Jadwal Pelayaran')

@section('content')
<div class="container mt-4">
    <h4>Edit Jadwal</h4>
    <div class="card p-3 mt-3">
        <form action="{{ route('jadwalpelayaran.update', $jadwal->id_jadwal) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Pilih Kapal -->
            <div class="mb-3">
                <label class="form-label">Kapal</label>
                <select name="id_kapal" class="form-select" required>
                    @foreach ($kapal as $k)
                        <option value="{{ $k->id_kapal }}"
                            {{ $jadwal->id_kapal == $k->id_kapal ? 'selected' : '' }}>
                            {{ $k->nama_kapal }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pelabuhan Asal -->
            <div class="mb-3">
                <label class="form-label">Pelabuhan Asal</label>
                <input 
                    type="text" 
                    name="pelabuhan_asal" 
                    class="form-control" 
                    list="list_pelabuhan" 
                    value="{{ old('pelabuhan_asal', optional($jadwal->asalPelabuhan)->nama_pelabuhan ?? $jadwal->pelabuhan_asal) }}" 
                    placeholder="Ketik atau pilih pelabuhan asal..." 
                    required>
            </div>

            <!-- Pelabuhan Tujuan -->
            <div class="mb-3">
                <label class="form-label">Pelabuhan Tujuan</label>
                <input 
                    type="text" 
                    name="pelabuhan_tujuan" 
                    class="form-control" 
                    list="list_pelabuhan" 
                    value="{{ old('pelabuhan_tujuan', optional($jadwal->tujuanPelabuhan)->nama_pelabuhan ?? $jadwal->pelabuhan_tujuan) }}" 
                    placeholder="Ketik atau pilih pelabuhan tujuan..." 
                    required>
            </div>

            <!-- Daftar pilihan pelabuhan -->
            <datalist id="list_pelabuhan">
                @foreach ($pelabuhan as $p)
                    <option value="{{ $p->nama_pelabuhan }}">
                @endforeach
            </datalist>

            <!-- Tanggal Berangkat -->
            <div class="mb-3">
                <label class="form-label">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat" class="form-control"
                       value="{{ old('tanggal_berangkat', $jadwal->tanggal_berangkat) }}" required>
            </div>

            <!-- Jam Berangkat -->
            <div class="mb-3">
                <label class="form-label">Jam Berangkat</label>
                <input type="time" name="jam_berangkat" class="form-control"
                       value="{{ old('jam_berangkat', $jadwal->jam_berangkat) }}" required>
            </div>

            <!-- Jam Tiba -->
            <div class="mb-3">
                <label class="form-label">Jam Tiba</label>
                <input type="time" name="jam_tiba" class="form-control"
                       value="{{ old('jam_tiba', $jadwal->jam_tiba) }}" required>
            </div>

            <!-- Harga Tiket -->
            <div class="mb-3">
                <label class="form-label">Harga Tiket</label>
                <input type="number" name="harga_tiket" class="form-control"
                       value="{{ old('harga_tiket', $jadwal->harga_tiket) }}" required>
            </div>

            <!-- Kelas Tiket -->
            <div class="mb-3">
                <label class="form-label">Kelas Tiket</label>
                <input type="text" name="kelas_tiket" class="form-control"
                       value="{{ old('kelas_tiket', $jadwal->kelas_tiket) }}" required>
            </div>

            <!-- Tombol Aksi -->
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('jadwalpelayaran.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
