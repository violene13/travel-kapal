@extends('layouts.adminpelayaran')

@section('title', 'Tambah Jadwal Pelayaran')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah </h4>

    <form action="{{ route('jadwalpelayaran.store') }}" method="POST"id="formSimpan">
        @csrf

        {{-- Jalur Pelayaran --}}
        <div class="mb-3">
            <label for="id_jalur" class="form-label">Jalur Pelayaran</label>
            <select name="id_jalur" id="id_jalur" class="form-select" required>
                <option value="">Pilih Jalur</option>
                @foreach ($jalur as $item)
                    <option value="{{ $item->id_jalur }}">
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
                    <option value="{{ $k->id_kapal }}">{{ $k->nama_kapal }}</option>
                @endforeach
            </select>
        </div>


        {{-- Tanggal & Jam --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat</label>
                <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam_berangkat" class="form-label">Jam Berangkat</label>
                <input type="time" name="jam_berangkat" id="jam_berangkat" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="jam_tiba" class="form-label">Jam Tiba</label>
                <input type="time" name="jam_tiba" id="jam_tiba" class="form-control" required>
            </div>
        </div>

        {{-- Kelas Tiket (dinamis dari Ticketing) --}}
        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas Tiket</label>
            <select name="kelas" id="kelas" class="form-select" required>
                <option value="">Pilih Kelas</option>
                {{-- opsi akan diisi otomatis via JS berdasarkan kapal + jalur --}}
            </select>
        </div>

        {{-- Harga Tiket --}}
        <div class="mb-3">
            <label for="harga" class="form-label">Harga Tiket</label>
            <input type="number" name="harga" id="harga" class="form-control" readonly required>
        </div>

        <div class="mt-4">
              <button type="submit" class="btn btn-primary" id="btnSimpan"> 
                 Simpan
            </button>
            <a href="{{ route('jadwalpelayaran.index') }}" class="btn btn-secondary">
              Batal
            </a>
        </div>
    </form>
</div>

{{-- Script Dinamis --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const jalur = document.getElementById('id_jalur');
    const kapal = document.getElementById('id_kapal');
    const kelas = document.getElementById('kelas');
    const harga = document.getElementById('harga');

    // Fungsi untuk load kelas berdasarkan jalur + kapal
    async function loadKelas() {
        kelas.innerHTML = '<option value="">Memuat kelas...</option>';
        harga.value = '';

        if (!jalur.value || !kapal.value) {
            kelas.innerHTML = '<option value="">Pilih Kelas</option>';
            return;
        }

        try {
            const res = await fetch(`{{ url('/admin/pelayaran/get-kelas') }}/${jalur.value}?id_kapal=${kapal.value}`);
            const data = await res.json();

            if (data.kelas && data.kelas.length > 0) {
                kelas.innerHTML = '<option value="">Pilih Kelas</option>';
                data.kelas.forEach(k => {
                    const opt = document.createElement('option');
                    opt.value = k;
                    opt.textContent = k;
                    kelas.appendChild(opt);
                });
            } else {
                kelas.innerHTML = '<option value="">Tidak ada kelas tersedia</option>';
            }
        } catch (err) {
            kelas.innerHTML = '<option value="">Gagal memuat kelas</option>';
        }
    }

    // Fungsi untuk ambil harga
    async function updateHarga() {
        const id_jalur = jalur.value;
        const id_kapal = kapal.value;
        const kelasVal = kelas.value;

        if (id_jalur && id_kapal && kelasVal) {
            try {
                const res = await fetch(`{{ url('/admin/pelayaran/get-harga') }}/${id_jalur}/${kelasVal}?id_kapal=${id_kapal}`);
                const data = await res.json();
                harga.value = data.harga ?? 0;
            } catch (err) {
                harga.value = 0;
            }
        } else {
            harga.value = '';
        }
    }

    // Event listener
    jalur.addEventListener('change', loadKelas);
    kapal.addEventListener('change', loadKelas);
    kelas.addEventListener('change', updateHarga);
});
</script>

<script>
document.getElementById('btnSimpan').addEventListener('click', function (e) {
    e.preventDefault(); // tahan submit dulu

    Swal.fire({
        title: 'Yakin menyimpan data?',
        text: 'Pastikan data jadwal sudah benar',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formSimpan').submit();
        }
    });
});
</script>
@endpush
@endsection
