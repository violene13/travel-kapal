@extends('layouts.adminpelayaran')

@section('title', 'Daftar Harga Tiket')

@section('content')

<style>
    .content-wrapper {
        margin-left: 260px;
        padding: 30px 40px;
        width: calc(100% - 260px);
        background-color: #f4f8fb;
        min-height: 100vh;
    }

    .page-title {
        font-weight: 600;
        color: #003b5c;
    }

    .card {
        border-radius: 10px;
        box-shadow: none;
    }

    .btn {
        border-radius: 6px;
        font-size: 14px;
        padding: 6px 12px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="page-title">Harga Tiket</h3>
    <a href="{{ route('ticketing.create') }}" class="btn btn-success shadow-sm">
        Tambah Tiket
    </a>
</div>

<div class="card border-0 rounded-4">
    <div class="card-body">
        <div class="table-responsive">

            <table id="ticketTable"
                   class="table table-bordered table-striped align-middle text-center mb-0">

                <thead class="table-success">
                <tr>
                    <th>No</th>
                    <th>Nama Kapal</th>
                    <th>Rute</th>
                    <th>Kategori</th>
                    <th>Kelas</th>
                    <th>Harga</th>
                    <th width="140">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @php
                    $grouped = $ticketing->groupBy(fn($t) =>
                        $t->id_kapal.'|'.$t->id_jalur.'|'.$t->kelas
                    );
                @endphp

                @foreach($grouped as $group)
                    @php
                        $first = $group->first();
                        $groupKey = $first->id_kapal.'|'.$first->id_jalur.'|'.$first->kelas;
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $first->kapal->nama_kapal ?? '-' }}</td>

                        <td>
                            {{ $first->jalur->pelabuhanAsal->lokasi ?? '-' }}
                            →
                            {{ $first->jalur->pelabuhanTujuan->lokasi ?? '-' }}
                        </td>

                        {{-- KATEGORI --}}
                        <td>
                            @foreach($group as $t)
                                <span class="badge
                                    @if($t->jenis_tiket === 'Dewasa') text-bg-primary
                                    @elseif($t->jenis_tiket === 'Anak') text-bg-warning
                                    @else text-bg-info
                                    @endif
                                    mb-1">
                                    {{ $t->jenis_tiket }}
                                </span>
                            @endforeach
                        </td>

                        {{-- KELAS --}}
                        <td>{{ $first->kelas }}</td>

                        {{-- HARGA --}}
                        <td class="text-start">
                            @foreach($group as $t)
                                <div class="mb-1">
                                    <span class="badge
                                        @if($t->jenis_tiket === 'Dewasa') text-bg-primary
                                        @elseif($t->jenis_tiket === 'Anak') text-bg-warning
                                        @else text-bg-secondary
                                        @endif">
                                        {{ $t->jenis_tiket }}
                                    </span>
                                    Rp {{ number_format($t->harga, 0, ',', '.') }}
                                </div>
                            @endforeach
                        </td>

                        {{-- AKSI (WAJIB DI DALAM <td>) --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('ticketing.edit', $groupKey) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('ticketing.destroy', $groupKey) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#ticketTable').DataTable({
        scrollX: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [10, 25, 50],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        }
    });
});
</script>
@endpush

@endsection
