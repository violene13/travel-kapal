@extends('layouts.adminpelayaran')

@section('title', 'Jalur Pelayaran')

@section('content')
<div class="container mt-3">
    {{-- Judul Halaman --}}
    <h3 class="mb-3">Jalur Pelayaran</h3>

    {{-- Card Box --}}
    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Baris atas: search & entries di kiri, tombol tambah di kanan --}}
            <div class="row mb-3">
                <div class="col-md-6 d-flex align-items-center gap-3" id="datatable-controls"></div>
                <div class="col-md-6 d-flex justify-content-end">
                    <a href="{{ route('jalurpelayaran.create') }}" class="btn btn-success">
                         Tambah Jalur
                    </a>
                </div>
            </div>

            {{-- Tabel Data jalurpelayaran --}}
            <table id="jalurpelayaranTable" class="table table-bordered table-striped align-middle w-100">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Pelabuhan Asal</th>
                        <th>Pelabuhan Tujuan</th>
                        <th>Durasi</th>
                        <th>Jarak</th>          
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jalur as $j)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $j->pelabuhanAsal->nama_pelabuhan ?? '-' }}</td>
                            <td>{{ $j->pelabuhanTujuan->nama_pelabuhan ?? '-' }}</td>
                            <td>{{ $j->durasi }}</td>
                            <td>{{ $j->jarak }}</td>
                            <td class="text-center">
                                <a href="{{ route('jalurpelayaran.edit', $j->id_jalur) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('jalurpelayaran.destroy', $j->id_jalur) }}" method="POST" class="d-inline">
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
                            <td colspan="6" class="text-center text-muted">Belum ada data jalur.</td>
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
        let table = $('#jalurpelayaranTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            },
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            order: [[0, "asc"]],
            dom: 'lfrtip' // length + filter (search) + table + pagination
        });

        // Pindahkan search & entries ke kiri
        $('#datatable-controls').append($('.dataTables_length'));
        $('#datatable-controls').append($('.dataTables_filter'));
    });
</script>
@endpush
