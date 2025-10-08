@extends('layouts.adminpelayaran')

@section('title', 'Data Pelabuhan')

@section('content')
<div class="container mt-3">
    <h3 class="mb-3">Data Pelabuhan</h3>

      <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('datapelabuhan.create') }}" class="btn btn-add">
           Tambah Pelabuhan
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="dataPelabuhanTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelabuhan</th>
                        <th>Lokasi</th>
                        <th>Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelabuhan as $p)
                    <tr>
                       <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $p->nama_pelabuhan }}</td>
                        <td>{{ $p->lokasi }}</td>
                        <td>{{ $p->fasilitas_pelabuhan }}</td>
                        <td>
                            <a href="{{ route('datapelabuhan.edit', $p->id_pelabuhan) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('datapelabuhan.destroy', $p->id_pelabuhan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataPelabuhanTable').DataTable({
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
