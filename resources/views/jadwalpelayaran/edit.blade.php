@extends('layouts.adminpelayaran')

@section('title', 'Edit Jadwal Pelayaran')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Jadwal Pelayaran</h4>

    <form action="{{ route('jadwalpelayaran.update', $jadwal->id_jadwal) }}" method="POST" id="formEdit">
        @csrf
        @method('PUT')

        {{-- JALUR --}}
        <div class="mb-3">
            <label class="form-label">Jalur Pelayaran</label>
            <select name="id_jalur" id="id_jalur" class="form-select" required>
                <option value="">Pilih Jalur</option>
                @foreach ($jalur as $item)
                    <option value="{{ $item->id_jalur }}" {{ $jadwal->id_jalur == $item->id_jalur ? 'selected' : '' }}>
                        {{ $item->pelabuhanAsal->lokasi ?? '-' }} → {{ $item->pelabuhanTujuan->lokasi ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- KAPAL --}}
        <div class="mb-3">
            <label class="form-label">Nama Kapal</label>
            <select name="id_kapal" id="id_kapal" class="form-select" required>
                <option value="">Pilih Kapal</option>
                @foreach ($kapal as $k)
                    <option value="{{ $k->id_kapal }}" {{ $jadwal->id_kapal == $k->id_kapal ? 'selected' : '' }}>
                        {{ $k->nama_kapal }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TANGGAL & JAM --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat" class="form-control" value="{{ $jadwal->tanggal_berangkat }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jam Berangkat</label>
                <input type="time" name="jam_berangkat" class="form-control" value="{{ $jadwal->jam_berangkat }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jam Tiba</label>
                <input type="time" name="jam_tiba" class="form-control" value="{{ $jadwal->jam_tiba }}" required>
            </div>
        </div>

        {{-- KELAS --}}
        <div class="mb-3">
            <label class="form-label">Kelas Tiket</label>
            <select name="kelas" id="kelas" class="form-select" required>
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k }}" {{ $jadwal->kelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>

        {{-- KATEGORI & HARGA --}}
        <div class="mb-3">
            <label class="form-label">Kategori Tiket & Harga</label>
            <div id="kategoriWrapper" class="border rounded p-3">
                {{-- Diisi JS otomatis --}}
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success" id="btnSimpan">Simpan Perubahan</button>
            <a href="{{ route('jadwalpelayaran.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const jalur = document.getElementById('id_jalur');
    const kapal = document.getElementById('id_kapal');
    const kelas = document.getElementById('kelas');
    const wrapper = document.getElementById('kategoriWrapper');

    async function loadKategori() {
        wrapper.innerHTML = 'Memuat kategori...';
        if (!jalur.value || !kapal.value || !kelas.value) {
            wrapper.innerHTML = '<span class="text-muted">Lengkapi data di atas</span>';
            return;
        }

        const res = await fetch(`/api/jalur/${jalur.value}/kategori?id_kapal=${kapal.value}&kelas=${kelas.value}`);
        const data = await res.json();

        if (!data.kategori.length) {
            wrapper.innerHTML = '<span class="text-muted">Tidak ada kategori</span>';
            return;
        }

        let html = '<div class="row">';
        for (const k of data.kategori) {
            const resHarga = await fetch(`/api/jalur/${jalur.value}/harga?id_kapal=${kapal.value}&kelas=${kelas.value}&jenis_tiket=${k}`);
            const harga = await resHarga.json();

            html += `
            <div class="col-md-4 mb-3">
                <label class="form-label text-capitalize">${k}</label>
                <input type="hidden" name="ticketing[${k}][aktif]" value="1">
                <input type="number" class="form-control" name="ticketing[${k}][harga]" value="${harga.harga ?? 0}" readonly>
            </div>`;
        }
        html += '</div>';
        wrapper.innerHTML = html;
    }

    [jalur, kapal, kelas].forEach(el => el.addEventListener('change', loadKategori));
    loadKategori(); // load kategori + harga saat page edit
});
</script>
@endpush
@endsection
