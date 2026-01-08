@extends('layouts.adminpelayaran')

@section('title', 'Tambah Jadwal Pelayaran')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Jadwal Pelayaran</h4>

    <form action="{{ route('jadwalpelayaran.store') }}" method="POST" id="formSimpan">
        @csrf

        {{-- JALUR --}}
        <div class="mb-3">
            <label class="form-label">Jalur Pelayaran</label>
            <select name="id_jalur" id="id_jalur" class="form-select" required>
                <option value="">Pilih Jalur</option>
                @foreach ($jalur as $item)
                    <option value="{{ $item->id_jalur }}">
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
                    <option value="{{ $k->id_kapal }}">{{ $k->nama_kapal }}</option>
                @endforeach
            </select>
        </div>

        {{-- TANGGAL & JAM --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jam Berangkat</label>
                <input type="time" name="jam_berangkat" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Jam Tiba</label>
                <input type="time" name="jam_tiba" class="form-control" required>
            </div>
        </div>

        {{-- KELAS --}}
        <div class="mb-3">
            <label class="form-label">Kelas Tiket</label>
            <select name="kelas" id="kelas" class="form-select" required>
                <option value="">Pilih Kelas</option>
            </select>
        </div>

        {{-- KATEGORI & HARGA --}}
        <div class="mb-3">
            <label class="form-label">Kategori Tiket & Harga</label>
            <div id="kategoriWrapper" class="border rounded p-3">
                <span class="text-muted">Pilih jalur, kapal, dan kelas terlebih dahulu</span>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
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

    async function loadKelas() {
        kelas.innerHTML = '<option value="">Memuat...</option>';
        wrapper.innerHTML = '<span class="text-muted">Pilih kelas terlebih dahulu</span>';

        if (!jalur.value || !kapal.value) {
            kelas.innerHTML = '<option value="">Pilih Kelas</option>';
            return;
        }

        const res = await fetch(`/api/jalur/${jalur.value}/kelas?id_kapal=${kapal.value}`);
        const data = await res.json();

        kelas.innerHTML = '<option value="">Pilih Kelas</option>';
        data.kelas.forEach(k => {
            kelas.innerHTML += `<option value="${k}">${k}</option>`;
        });
    }

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

    [jalur, kapal].forEach(el => el.addEventListener('change', loadKelas));
    kelas.addEventListener('change', loadKategori);
});
</script>
@endpush
@endsection
