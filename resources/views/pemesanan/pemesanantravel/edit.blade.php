@extends('layouts.admintravel')

@section('title', 'Edit Pemesanan')

@section('content')
<div class="container mt-4">
  <h2 class="fw-bold text-primary mb-4">Edit Pemesanan</h2>

  <form action="{{ route('pemesanan.pemesanantravel.update', $pemesanan->id_pemesanan) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Pemesan Utama</label>
        <input type="text" class="form-control" value="{{ $pemesanan->penumpang->nama_penumpang }}" readonly>
      </div>

      <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="Pending" {{ $pemesanan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
          <option value="Confirmed" {{ $pemesanan->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
          <option value="Cancelled" {{ $pemesanan->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
      </div>
    </div>

    <div class="text-end">
      <a href="{{ route('pemesanan.pemesanantravel.index') }}" class="btn btn-secondary">Kembali</a>
      <button class="btn btn-success">Perbarui</button>
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
