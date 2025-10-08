@extends('layouts.adminpelayaran')

@section('title', 'Jadwal Pelayaran')

@section('content')
<div class="container mt-4">

    {{-- Header judul + tombol tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Jadwal Pelayaran</h3>
        <a href="{{ route('jadwalpelayaran.create') }}" class="btn btn-add">Tambah Jadwal</a>
    </div>

    {{-- Wrapper tabel scroll --}}
    <div class="table-responsive">
        <table id="jadwalpelayaranTable" class="table table-bordered table-striped nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kapal</th>
                    <th>Pelabuhan Asal</th>
                    <th>Pelabuhan Tujuan</th>
                    <th>Tanggal Berangkat</th>
                    <th>Jam Berangkat</th>
                    <th>Jam Tiba</th>
                    <th>Harga Tiket</th>
                    <th>Kelas Tiket</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->kapal->nama_kapal ?? '-' }}</td>
                        <td>{{ $item->jalur->pelabuhanAsal->nama_pelabuhan ?? '-' }}</td>
                        <td>{{ $item->jalur->pelabuhanTujuan->nama_pelabuhan ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_berangkat)->format('d-m-Y') }}</td>
                        <td>{{ $item->jam_berangkat }}</td>
                        <td>{{ $item->jam_tiba }}</td>
                        <td>Rp {{ number_format($item->harga_tiket, 0, ',', '.') }}</td>
                        <td>{{ $item->kelas_tiket }}</td>
                        <td class="text-center">
                            <a href="{{ route('jadwalpelayaran.edit', $item->id_jadwal) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('jadwalpelayaran.destroy', $item->id_jadwal) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
    {{-- ✅ DataTables Bootstrap 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    {{-- ✅ jQuery + DataTables + Bootstrap 5 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function (    ) {
            $('#jadwalpelayaranTable').DataTable({
                scrollX: true,
                pageLength: 5, // tampilkan 5 data per halaman
                lengthMenu: [5, 10, 25, 50], // opsi pilihan entries
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                dom: '<"row mb-3"<"col-md-6 d-flex justify-content-start"l><"col-md-6 d-flex justify-content-start"f>>rtip'
            });
        });
    </script>
@endpush
