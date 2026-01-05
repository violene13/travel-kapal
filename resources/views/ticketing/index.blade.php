@extends('layouts.adminpelayaran')

@section('title', 'Daftar Harga Tiket')

@section('content')
    {{-- ===== HEADER PAGE ===== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">Harga Tiket</h3>
        <a href="{{ route('ticketing.create') }}" class="btn btn-success shadow-sm">
             Tambah Tiket
        </a>
    </div>

    {{-- ===== TABEL ===== --}}
     <div class="card border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">
            <table id="ticketTable" class="table table-bordered table-striped align-middle text-center mb-0">
               <thead class="table-success table-header">

                    <tr>
                        <th>No</th>
                        <th>Nama Kapal</th>
                        <th>Rute</th>
                        <th>Kategori</th>
                        <th>Kelas</th>
                        <th>Harga (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ticketing as $index => $ticket)
                       <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ticket->kapal->nama_kapal ?? '-' }}</td>

                        <td>
                            @if($ticket->jalur && $ticket->jalur->pelabuhanAsal && $ticket->jalur->pelabuhanTujuan)
                                {{ $ticket->jalur->pelabuhanAsal->lokasi }} →
                                {{ $ticket->jalur->pelabuhanTujuan->lokasi }}
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </td>

                       <td>
                        <span class="badge 
                            @if($ticket->jenis_tiket == 'Dewasa') bg-primary
                            @elseif($ticket->jenis_tiket == 'Anak') bg-warning
                            @else bg-info
                            @endif">
                            {{ $ticket->jenis_tiket }}
                        </span>
                    </td>

                        <td>{{ $ticket->kelas }}</td>
                        <td>Rp {{ number_format($ticket->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('ticketing.edit', $ticket->id_ticketing) }}"
                            class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('ticketing.destroy', $ticket->id_ticketing) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
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

{{-- ====================== STYLE FIX ====================== --}}
<style>
    /* ✅ Pastikan konten tidak ketutupan sidebar */
    .content-wrapper {
        margin-left: 260px; /* Sesuaikan dengan lebar sidebar kamu */
        padding: 30px 40px; /* Jarak ideal dari tepi */
        width: calc(100% - 260px);
        background-color: #f4f8fb;
        min-height: 100vh;
        transition: all 0.3s ease;
    }

    .page-title {
        font-weight: 600;
        color: #003b5c;
    }
 
    /* Card utama biar rapi */
    .card {
        margin: 0;
        border-radius: 10px;
        box-shadow: none
    }

    /* DataTables filter dan length biar sejajar */
    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
    }

    div.dataTables_wrapper div.dataTables_length {
        float: left;
    }

    /* Tombol */
    .btn {
        border-radius: 6px;
        font-size: 14px;
        padding: 6px 12px;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #000;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        color: #fff;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #bb2d3b;
    }
</style>

{{-- ====================== DATATABLES ====================== --}}
@push('styles')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#ticketTable').DataTable({
        scrollX: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        dom: '<"row mb-3"<"col-md-6 d-flex justify-content-start"l><"col-md-6 d-flex justify-content-end"f>>rtip'
    });
});
</script>
@endpush
@endsection
