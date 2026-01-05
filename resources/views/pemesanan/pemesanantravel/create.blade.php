@extends('layouts.admintravel')

@section('title', 'Tambah Pemesanan Travel')

@section('content')
<div class="container-fluid px-4">
  <h2 class="text-dark mb-4">Tambah Pemesanan</h2>

  {{-- Pesan Error --}}
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <form action="{{ route('pemesanan.pemesanantravel.store') }}" method="POST" id="formPemesanan">
    @csrf

    {{-- ==================== DATA PENUMPANG ==================== --}}
    <div class="card shadow-sm p-4 mb-4">
      <h5 class="fw-bold mb-3 text-secondary">Data Penumpang</h5>

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Penumpang</label>
          <input type="text" id="nama_penumpang" name="penumpang[nama_penumpang]" class="form-control" 
                 value="{{ old('penumpang.nama_penumpang') }}" required autocomplete="off">
          <small class="text-muted">Jika penumpang sudah ada, data akan otomatis terisi</small>
          @error('penumpang.nama_penumpang') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="col-md-6">
          <label class="form-label">No. KTP</label>
          <input type="text" id="no_ktp" name="penumpang[no_ktp]" class="form-control" value="{{ old('penumpang.no_ktp') }}" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">No. HP</label>
          <input type="text" id="no_hp" name="penumpang[no_hp]" class="form-control" value="{{ old('penumpang.no_hp') }}" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" id="email" name="penumpang[email]" class="form-control" value="{{ old('penumpang.email') }}">
        </div>

        <div class="col-md-12">
          <label class="form-label">Alamat</label>
          <textarea id="alamat" name="penumpang[alamat]" class="form-control" required>{{ old('penumpang.alamat') }}</textarea>
        </div>

        <div class="col-md-4">
          <label class="form-label">Jenis Kelamin</label>
          <select id="gender" name="penumpang[gender]" class="form-select">
            <option value="">-- Pilih --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
          </select>
        </div>

        <div class="col-md-4">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" id="tanggal_lahir" name="penumpang[tanggal_lahir]" class="form-control">
        </div>
      </div>
    </div>

    {{-- ==================== DATA JADWAL ==================== --}}
    <div class="card shadow-sm p-4 mb-4">
      <h5 class="fw-bold mb-3 text-secondary">Pilih Jadwal Pelayaran</h5>
      <div class="mb-3">
        <label class="form-label">Jadwal Pelayaran</label>
        <select name="id_jadwal" class="form-select" required>
          <option value="">-- Pilih Jadwal --</option>
          @foreach($jadwals as $jadwal)
            <option value="{{ $jadwal->id_jadwal }}">
              {{ $jadwal->kapal->nama_kapal ?? 'Kapal Tidak Dikenal' }} |
              {{ $jadwal->jalur->pelabuhanAsal->lokasi ?? 'Asal Tidak Dikenal' }} →
              {{ $jadwal->jalur->pelabuhanTujuan->lokasi ?? 'Tujuan Tidak Dikenal' }}
              ({{ \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->translatedFormat('d M Y') }},
              {{ $jadwal->jam_berangkat }} - {{ $jadwal->jam_tiba }})
            </option>
          @endforeach
        </select>
        @error('id_jadwal') <small class="text-danger">{{ $message }}</small> @enderror
      </div>
    </div>

    {{-- ==================== TOMBOL SIMPAN ==================== --}}
    <div class="mt-4 text-end">
      <a href="{{ route('pemesanan.pemesanantravel.index') }}" class="btn btn-secondary">
        Kembali
      </a>
      <button type="submit" class="btn btn-primary" id="btnSimpan">
  Simpan
</button>
    </div>
  </form>
</div>

{{-- ==================== SCRIPT AJAX ==================== --}}
<script>
document.getElementById('nama_penumpang').addEventListener('blur', function() {
  let nama = this.value.trim();
  if (nama.length > 0) {
    fetch(`/get-penumpang-by-name?nama=${encodeURIComponent(nama)}`)
      .then(res => res.json())
      .then(data => {
        if (!data.error) {
          document.getElementById('no_ktp').value = data.no_ktp ?? '';
          document.getElementById('no_hp').value = data.no_hp ?? '';
          document.getElementById('email').value = data.email ?? '';
          document.getElementById('alamat').value = data.alamat ?? '';
          document.getElementById('tanggal_lahir').value = data.tanggal_lahir ?? '';
          document.getElementById('gender').value = data.gender ?? '';
        }
      })
      .catch(err => console.error('Error:', err));
  }
});
</script>
<script>
document.getElementById('btnSimpan').addEventListener('click', function (e) {
    e.preventDefault(); // tahan submit dulu

    Swal.fire({
        title: 'Yakin menyimpan data?',
        text: 'Pastikan data pemesanan sudah benar',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#0d6efd',
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formPemesanan').submit();
        }
    });
});
</script>

@endsection
