@extends('layouts.adminpelayaran')

@section('content')
<div class="container mt-4">
    {{-- Judul Halaman --}}
    <h2 class="fw-bold mb-4">Data Penumpang Pelayaran</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Wrapper Tabel --}}
    <div class="card border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="penumpangTable" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead class="table-success table-header">
                    <tr>
                        <th>No</th>
                        <th>Nama Penumpang</th>
                        <th>Email</th>
                        <th>No Handphone</th>
                        <th>Alamat</th>
                        <th>No KTP</th>
                        <th>Gender</th>
                        <th>Tanggal Lahir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penumpangs as $p)
                        <tr class="align-middle text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama_penumpang }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->no_hp ?? '-' }}</td>
                            <td>{{ $p->alamat ?? '-' }}</td>
                            <td>{{ $p->no_ktp ?? '-' }}</td>
                            <td>{{ $p->gender ?? '-' }}</td>
                            <td>{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') : '-' }}</td>
                            <td>
                                <form action="{{ route('penumpang.penumpangpelayaran.destroy', $p->id_penumpang) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Tidak ada data penumpang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('admin.pelayaran.dashboard') }}" class="btn btn-primary px-4">
            Kembali
        </a>
    </div>
</div>

{{-- Script DataTables --}}
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
