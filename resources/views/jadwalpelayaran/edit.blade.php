@extends('layouts.adminpelayaran')

@section('title', 'Edit Jadwal Pelayaran')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Edit Jadwal Pelayaran</h4>

    <div class="card p-4 shadow-sm">
        <form action="{{ route('jadwalpelayaran.update', $jadwal->id_jadwal) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Jalur Pelayaran --}}
            <div class="mb-3">
                <label for="id_jalur" class="form-label">Jalur Pelayaran</label>
                <select name="id_jalur" id="id_jalur" class="form-select" required>
                    <option value="">Pilih Jalur</option>
                    @foreach ($jalur as $item)
                        <option value="{{ $item->id_jalur }}" {{ $jadwal->id_jalur == $item->id_jalur ? 'selected' : '' }}>
                            {{ $item->pelabuhanAsal->lokasi ?? '-' }} -
                            {{ $item->pelabuhanTujuan->lokasi ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kapal --}}
            <div class="mb-3">
                <label for="id_kapal" class="form-label">Nama Kapal</label>
                <select name="id_kapal" id="id_kapal" class="form-select" required>
                    <option value="">Pilih Kapal</option>
                    @foreach ($kapal as $k)
                        <option value="{{ $k->id_kapal }}" {{ $jadwal->id_kapal == $k->id_kapal ? 'selected' : '' }}>
                            {{ $k->nama_kapal }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tujuan (gabungan Asal - Tujuan, otomatis update) --}}
            <div class="mb-3">
                <label class="form-label">Tujuan</label>
                <input type="text" id="tujuan_display" class="form-control" readonly
                    value="{{ ($jadwal->asalPelabuhan->nama_pelabuhan ?? '-') . ' - ' . ($jadwal->tujuanPelabuhan->nama_pelabuhan ?? '-') }}">
            </div>

            {{-- Tanggal, Jam --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat</label>
                    <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control"
                        value="{{ $jadwal->tanggal_berangkat }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="jam_berangkat" class="form-label">Jam Berangkat</label>
                    <input type="time" name="jam_berangkat" id="jam_berangkat" class="form-control"
                        value="{{ $jadwal->jam_berangkat }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="jam_tiba" class="form-label">Jam Tiba</label>
                    <input type="time" name="jam_tiba" id="jam_tiba" class="form-control"
                        value="{{ $jadwal->jam_tiba }}" required>
                </div>
            </div>

            {{-- Kelas Tiket --}}
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select name="kelas" id="kelas" class="form-select" required>
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k }}" {{ $jadwal->kelas == $k ? 'selected' : '' }}>
                            {{ $k }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Harga Tiket --}}
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Tiket</label>
                <input type="number" name="harga" id="harga" class="form-control"
                    value="{{ $jadwal->harga }}" readonly required>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('jadwalpelayaran.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script: Update Tujuan & Harga --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jalur = document.getElementById('id_jalur');
    const kapal = document.getElementById('id_kapal');
    const kelas = document.getElementById('kelas');
    const harga = document.getElementById('harga');
    const tujuanDisplay = document.getElementById('tujuan_display');

    // Update tampilan "Asal - Tujuan"
    function updateTujuan() {
        const asalText = asal.options[asal.selectedIndex]?.text || '-';
        const tujuanText = tujuan.options[tujuan.selectedIndex]?.text || '-';
        tujuanDisplay.value = `${asalText} - ${tujuanText}`;
    }

    // Ambil harga tiket otomatis
    function updateHarga() {
        const id_jalur = jalur.value;
        const kelasVal = kelas.value;
        const kapalId = kapal.value;

        if (!id_jalur || !kelasVal || !kapalId) {
            harga.value = '';
            return;
        }

        fetch(`{{ url('/admin/pelayaran/get-harga') }}/${id_jalur}/${kelasVal}?id_kapal=${kapalId}`)
            .then(res => res.json())
            .then(data => {
                harga.value = data.harga ?? 0;
            })
            .catch(() => {
                console.error("Gagal mengambil harga tiket.");
                harga.value = '';
            });
    }

    // Event listeners
    [jalur, kapal, kelas].forEach(el => el.addEventListener('change', updateHarga));
    [asal, tujuan].forEach(el => el.addEventListener('change', updateTujuan));

    // Jalankan saat halaman dimuat
    updateTujuan();
    updateHarga();
});
</script>
@endpush
@endsection
