@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Penumpang</h2>

    {{-- Wrapper biar tabel bisa digeser kanan-kiri --}}
    <div class="table-responsive">
        <table id="penumpangTable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Penumpang</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>No KTP</th>
                    <th>Gender</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penumpangs as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama_penumpang }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->password }}</td>
                        <td>{{ $p->no_hp ?? '-' }}</td>
                        <td>{{ $p->alamat ?? '-' }}</td>
                        <td>{{ $p->no_ktp ?? '-' }}</td>
                        <td>{{ $p->gender ?? '-' }}</td>
                        <td>{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                        <td>
                            <form action="{{ route('penumpang.destroy', $p->id_penumpang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                        <td colspan="10" class="text-center">Tidak ada data penumpang</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            Kembali
        </a>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#penumpangTable').DataTable({
            scrollX: true,
            autoWidth: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            columnDefs: [
                {
                    targets: -1,
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
@endsection
