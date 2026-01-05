@extends('layouts.adminpelayaran')

@section('title', 'Jadwal Pelayaran')

@section('content')
<div class="content-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title mb-0">Daftar Jadwal Pelayaran</h3>
        <a href="{{ route('jadwalpelayaran.create') }}" class="btn btn-success shadow-sm">
           Tambah 
        </a>
    </div>

     <div class="card border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="jadwalpelayaranTable" class="table table-bordered table-striped text-center align-middle mb-0">
                <thead class="table-header">
                    <tr>
                        <th>No</th>
                        <th>Nama Kapal</th>
                        <th>Rute</th>
                        <th>Tanggal Berangkat</th>
                        <th>Jam Berangkat</th>
                        <th>Jam Tiba</th>
                        <th>Kelas</th>
                        <th>Harga</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->kapal->nama_kapal ?? '-' }}</td>
                            <td>{{ $item->jalur->rute ?? '-' }}</td>
                        <td>
                            {{ $item->tanggal_berangkat 
                                ? \Carbon\Carbon::parse($item->tanggal_berangkat)->translatedFormat('d F Y') 
                                : '-' }}
                        </td>
                        <td>{{ $item->jam_berangkat ?? '-' }}</td>
                        <td>{{ $item->jam_tiba ?? '-' }}</td>
                        <td>{{ $item->kelas ?? '-' }}</td>
                        <td>
                            @if(!empty($item->harga))
                                <span class="badge bg-primary">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('jadwalpelayaran.edit', $item->id_jadwal) }}" class="btn btn-warning btn-sm me-1">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('jadwalpelayaran.destroy', $item->id_jadwal) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
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
</div>

<style>
/* Agar wrapper tidak membatasi lebar tabel */
.table-wrapper {
    width: 100% !important;
    overflow-x: auto !important;
}

table.dataTable thead th {
    background-color: #d1e7dd !important;
    color: #000 !important;
    font-weight: 600 !important;
    text-align: center !important;
    white-space: nowrap !important;
}

/* Tabel memanjang */
#jadwalpelayaranTable {
    width: 100% !important;
    min-width: 1400px;
}

#jadwalpelayaranTable td {
    padding: 10px !important;
    white-space: nowrap;
}

/* Border halus */
.table-bordered > :not(caption) > * > * {
    border-color: #cccccc !important;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f8f9fa !important;
}
</style>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#jadwalpelayaranTable').DataTable({
        scrollX: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        autoWidth: false
    });
});
</script>
@endpush

@endsection
