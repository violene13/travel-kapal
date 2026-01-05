@extends('layouts.adminpelayaran')

@section('title', 'Jalur Pelayaran')

@section('content')
<div class="content-wrapper">

    {{-- HERO: judul + tombol (di atas, di atas card, langsung di background biru muda) --}}
    <div class="hero d-flex justify-content-between align-items-center">
        <h3 class="page-title mb-0">Daftar Jalur Pelayaran</h3>
        <a href="{{ route('jalurpelayaran.create') }}" class="btn btn-success shadow-sm">
            Tambah Jalur
        </a>
    </div>

    {{-- White card yang menampung DataTable --}}
   <div class="card border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
                <table id="jalurpelayaranTable" class="table table-bordered table-striped text-center align-middle mb-0">
                   <thead class="table-header table-success">

                        <tr>
                            <th>No</th>
                            <th>Lokasi Asal</th>
                            <th>Lokasi Tujuan</th>
                            <th>Durasi</th>
                            <th>Jarak</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jalur as $j)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $j->pelabuhanAsal->lokasi ?? '-' }}</td>
                                <td>{{ $j->pelabuhanTujuan->lokasi ?? '-' }}</td>
                                <td>{{ $j->durasi }}</td>
                                <td>{{ $j->jarak }}</td>
                                <td>
                                    <a href="{{ route('jalurpelayaran.edit', $j->id_jalur) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('jalurpelayaran.destroy', $j->id_jalur) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                <td colspan="6" class="text-center text-muted">Belum ada data jalur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('admin.pelayaran.dashboard') }}" class="btn btn-primary btn-sm">
            Kembali
        </a>
    </div>
</div>

{{-- ===================== STYLE ===================== --}}
<style>


/* === Header judul === */
.page-title {
    color: #003B5C;
    font-weight: 700;
}

/* tombol tampil kontras dengan hero (tetap menggunakan btn-success) */
.hero .btn-success {
    background-color: #198754;
    border: none;
    box-shadow: 0 3px 8px rgba(25, 135, 84, 0.12);
}

/* ===== White card untuk tabel (di bawah hero) ===== */
.

/* beri jarak internal pada card */
.table-container .p-3 {
    padding: 18px !important;
}

/* isi tabel */
.table td {
    vertical-align: middle;
    white-space: nowrap;
}

/* responsive wrapper agar datatable controls ada di dalam card */
.table-responsive {
    overflow-x: auto;
    width: 100%;
}

/* tombol edit/hapus */
.btn-warning, .btn-danger {
    color: #fff;
}

/* global */
body {
    background-color: transparent;
    overflow-x: hidden;
}
</style>

{{-- ===================== SCRIPT DATATABLE ===================== --}}
@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#jalurpelayaranTable').DataTable({
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
