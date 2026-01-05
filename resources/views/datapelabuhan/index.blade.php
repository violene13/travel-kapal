@extends('layouts.adminpelayaran')

@section('title', 'Data Pelabuhan')

@section('content')
<div class="content-wrapper mt-4">

    {{-- Header judul + tombol tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title fw-bold">Daftar Data Pelabuhan</h3>
        <a href="{{ route('datapelabuhan.create') }}" class="btn btn-success shadow-sm">
          Tambah 
        </a>
    </div>

    {{-- Card / Box tabel --}}
    <div class="card border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataPelabuhanTable" class="table table-bordered table-striped text-center align-middle mb-0">
              <thead class="table-success table-header">

                    <tr>
                        <th>No</th>
                        <th>Nama Pelabuhan</th>
                        <th>Lokasi</th>
                        <th>Fasilitas</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataPelabuhan as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start">{{ $item->nama_pelabuhan ?? '-' }}</td>
                            <td>{{ $item->lokasi ?? '-' }}</td>
                            <td class="text-start">{{ $item->fasilitas_pelabuhan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('datapelabuhan.edit', $item->id_pelabuhan) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('datapelabuhan.destroy', $item->id_pelabuhan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelabuhan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted text-center">Belum ada data pelabuhan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('admin.pelayaran.dashboard') }}" class="btn btn-primary btn-sm">
            Kembali
        </a>
    </div>
</div>

{{-- ===================== STYLE KHUSUS HALAMAN (HANYA POSISI) ===================== --}}
<style>
    /**
     * PENTING:
     * Jangan set margin-left di sini (karena layout sudah mengatur margin-left untuk content).
     * Gunakan padding-left untuk memberi jarak kecil dari sidebar.
     */

    .content-wrapper {
        margin: 0;                /* <- pastikan tidak mendorong konten ke kanan */
        padding-left: 10px;       /* <- jarak dari sidebar (bisa diubah 20/30/40 px) */
        padding-right: 30px;
        padding-top: 0;
        padding-bottom: 40px;
        background-color: transparent; /* biarkan layout mengatur warna latar */
    }

    /* tetap pertahankan header & warna */
    .page-title {
        color: #003B5C;
        font-weight: 700;
    }

    .table-responsive {
        overflow-x: auto;
        width: 100%;
    }

    .table-wrapper {
        border-radius: 10px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* pastikan teks nama/fasilitas align start supaya rapi ketika tabel disusutkan */
    table td.text-start, table th.text-start {
        text-align: left;
    }
</style>

{{-- ===================== SCRIPT DATATABLE ===================== --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataPelabuhanTable').DataTable({
        scrollX: true,      // biar tabel bisa scroll horizontal saja
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [10, 25, 50],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        dom: '<"row mb-3"<"col-md-6 d-flex justify-content-start"l><"col-md-6 d-flex justify-content-end"f>>rtip'
    });
});
</script>
@endpush
@endsection
