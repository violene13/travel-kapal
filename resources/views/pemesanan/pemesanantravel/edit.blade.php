@extends('layouts.admintravel')

@section('title', 'Edit Pemesanan')

@section('content')
<div class="container mt-4">
  <h2 class="fw-bold text-primary mb-4">Edit Pemesanan</h2>

  <form id="formPemesanan"
      action="{{ route('pemesanan.pemesanantravel.update', $pemesanan->id_pemesanan) }}"
      method="POST">

    @csrf
    @method('PUT')

    <div class="row mb-3">
      <div class="col-md-4">
        <label for="no_ktp" class="form-label">No KTP Penumpang</label>
        <select name="id_penumpang" id="no_ktp" class="form-select" required>
          @foreach($penumpang as $item)
            <option value="{{ $item->id_penumpang }}" {{ $item->id_penumpang == $pemesanan->id_penumpang ? 'selected' : '' }}>
              {{ $item->no_ktp }} - {{ $item->nama_penumpang }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Nama Penumpang</label>
        <input type="text" id="nama_penumpang" class="form-control" value="{{ $pemesanan->penumpang->nama_penumpang ?? '' }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label">Jenis Kelamin</label>
        <input type="text" id="gender" class="form-control" value="{{ $pemesanan->penumpang->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Tanggal Lahir</label>
        <input type="text" id="tanggal_lahir" class="form-control" value="{{ $pemesanan->penumpang->tanggal_lahir ?? '' }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label">No HP</label>
        <input type="text" id="no_hp" class="form-control" value="{{ $pemesanan->penumpang->no_hp ?? '' }}" readonly>
      </div>
      <div class="col-md-4">
        <label class="form-label">Jadwal Pelayaran</label>
        <select name="id_jadwal" class="form-select" required>
          @foreach($jadwals as $j)
            <option value="{{ $j->id_jadwal }}" {{ $j->id_jadwal == $pemesanan->id_jadwal ? 'selected' : '' }}>
              {{ $j->jalur->rute }} | {{ $j->kapal->nama_kapal }} | {{ \Carbon\Carbon::parse($j->tanggal_berangkat)->format('d M Y') }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Tanggal Pesan</label>
        <input type="date" name="tanggal_pesan" class="form-control" value="{{ $pemesanan->tanggal_pesan }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="Pending" {{ $pemesanan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
          <option value="Confirmed" {{ $pemesanan->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
          <option value="Cancelled" {{ $pemesanan->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>
    </div>

    <div class="text-end">
      <a href="{{ route('pemesanan.pemesanantravel.index') }}" class="btn btn-secondary">Batal</a>
     <button type="submit" class="btn btn-success" id="btnPerbarui">
  Perbarui
    </div>
  </form>
</div>

<script>
document.getElementById('no_ktp').addEventListener('change', function() {
  let id = this.value;
  let data = @json($penumpang);
  let selected = data.find(p => p.id_penumpang == id);

  if (selected) {
    document.getElementById('nama_penumpang').value = selected.nama_penumpang;
    document.getElementById('gender').value = selected.gender === 'L' ? 'Laki-laki' : 'Perempuan';
    document.getElementById('tanggal_lahir').value = selected.tanggal_lahir;
    document.getElementById('no_hp').value = selected.no_hp;
  }
});
</script>

<script>
document.getElementById('btnPerbarui').addEventListener('click', function (e) {
    e.preventDefault(); 

    Swal.fire({
        title: 'Yakin memperbarui data?',
        text: 'Pastikan data sudah benar',
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
