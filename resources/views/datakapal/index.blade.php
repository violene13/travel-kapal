@extends('layouts.adminpelayaran')

@section('title', 'Data Kapal')

@section('content')
<div class="container mt-3">
    {{-- Judul Halaman --}}
    <h3 class="mb-3">Data Kapal</h3>

    {{-- Card Box --}}
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Tombol Tambah --}}
            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('datakapal.create') }}" class="btn btn-success">
                     Tambah Kapal
                </a>
            </div>

            {{-- Tabel Data Kapal --}}
            <table id="dataKapalTable" class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
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
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $k->nama_kapal }}</td>
                            <td>{{ $k->jenis_kapal }}</td>
                            <td>{{ $k->kapasitas }}</td>
                            <td class="text-center">
                                <a href="{{ route('datakapal.edit', $k->id_kapal) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('datakapal.destroy', $k->id_kapal) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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

    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('admin.pelayaran.dashboard') }}" class="btn btn-primary btn-sm">
            Kembali
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataKapalTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            order: [[0, "asc"]],
            dom: '<"row mb-3"<"col-md-12 d-flex justify-content-start gap-3"lf>>rtip'
        });
    });
</script>
@endpush
