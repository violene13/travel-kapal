@extends('layouts.adminpelayaran')

@section('title', 'Data Kapal')

@section('content')
<div class="content-wrapper mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="page-title fw-bold">Daftar Data Kapal</h3>
        <a href="{{ route('datakapal.create') }}" class="btn btn-success shadow-sm">
            Tambah 
        </a>
    </div>

   <div class="card border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataKapalTable" class="table table-bordered table-striped text-center align-middle mb-0">
               <thead class="table-success table-header">

                    <tr>
                        <th>No</th>
                        <th>Nama Kapal</th>
                        <th>Jenis Kapal</th>
                        <th>Kapasitas</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kapal as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kapal }}</td>
                            <td>{{ $k->jenis_kapal }}</td>
                            <td>{{ $k->kapasitas }}</td>
                            <td>
                                <a href="{{ route('datakapal.edit', $k->id_kapal) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('datakapal.destroy', $k->id_kapal) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kapal ini?');">
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
                            <td colspan="5" class="text-center text-muted">Belum ada data kapal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('admin.pelayaran.dashboard') }}" class="btn btn-primary btn-sm">
            Kembali
        </a>
    </div>
</div>

<style>
   
    .content-wrapper {
        margin: 0;
        padding-left: 25px;
        padding-right: 40px;
        padding-bottom: 40px;
        background-color: transparent;
    }

    /* Judul halaman */
    .page-title {
        color: #003B5C;
        font-weight: 700;
    }

    /* Card tabel */
    .card {
        border-radius: 10px;
        background-color: #fff;
        box-shadow: none
    }

    /* Scroll horizontal hanya di tabel */
    .table-responsive {
        overflow-x: auto;
        width: 100%;
    }

    /* Jaga teks tetap rapat dan rapi */
    table td, table th {
        white-space: nowrap;
    }

    /* Warna tombol tambah tetap hijau (default Bootstrap) */
    .btn-success {
        background-color: #198754 !important;
        border: none;
    }

    .btn-success:hover {
        background-color: #157347 !important;
    }
</style>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#dataKapalTable').DataTable({
        scrollX: true, 
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
