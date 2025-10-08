@extends('layouts.adminpelayaran')

@section('content')
<div class="container mt-4">
    <h4>Tambah Jadwal</h4>
    <div class="card p-3 mt-3">
        <form action="{{ route('jadwalpelayaran.store') }}" method="POST">
            @csrf

            <!-- Pilih Kapal -->
            <div class="mb-3">
                <label class="form-label">Kapal</label>
                <select name="id_kapal" class="form-select" required>
                    <option value="">Pilih Kapal</option>
                    @foreach ($kapal as $k)
                        <option value="{{ $k->id_kapal }}">{{ $k->nama_kapal }}</option>
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
                <input type="date" name="tanggal_berangkat" class="form-control" required>
            </div>

            <!-- Jam Berangkat -->
            <div class="mb-3">
                <label class="form-label">Jam Berangkat</label>
                <input type="time" name="jam_berangkat" class="form-control" required>
            </div>

            <!-- Jam Tiba -->
            <div class="mb-3">
                <label class="form-label">Jam Tiba</label>
                <input type="time" name="jam_tiba" class="form-control" required>
            </div>

            <!-- Harga Tiket -->
            <div class="mb-3">
                <label class="form-label">Harga Tiket</label>
                <input type="number" name="harga_tiket" class="form-control" required>
            </div>

            <!-- Kelas Tiket -->
            <div class="mb-3">
                <label class="form-label">Kelas Tiket</label>
                <input type="text" name="kelas_tiket" class="form-control" required>
            </div>

            <!-- Tombol Aksi -->
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('jadwalpelayaran.index') }}" class="btn btn-primary">Kembali</a>
        </form>
    </div>
</div>
@endsection
