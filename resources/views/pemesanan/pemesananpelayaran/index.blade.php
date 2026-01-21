@extends('layouts.adminpelayaran')

@section('title', 'Daftar Pemesanan Pelayaran')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold text-primary mb-4">Daftar Pemesanan Pelayaran</h2>

    <div class="table-responsive">
        <table id="pemesananPelayaranTable"
               class="table table-striped table-bordered nowrap w-100 align-middle">

            <thead class="table-success text-center">
                <tr>
                    <th>ID Pesanan</th>
                    <th>Sumber</th>
                    <th>Akun Pemesan</th>
                    <th>Jadwal</th>
                    <th>Rute</th>
                    <th>Kapal</th>
                    <th>Kelas</th>
                    <th>Jml Pen</th>
                    <th>Kategori</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($pemesanan as $item)
                <tr>

                    {{-- ID PESANAN --}}
                    <td class="text-center fw-semibold">
                        {{ str_pad($item->id_pemesanan, 5, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="text-center">
                        @switch($item->sumber_pemesanan)
                            @case('admin_travel')
                                <span class="badge bg-info">Travel</span>
                                @break
                            @case('admin_pelayaran')
                                <span class="badge bg-primary">Pelayaran</span>
                                @break
                            @default
                                <span class="badge bg-secondary">User</span>
                        @endswitch
                    </td>


                    {{-- akun PEMESAN --}}
                   <td>
                        @if(optional($item->penumpang)->email)
                            <small class="text-muted">
                                {{ $item->penumpang->email }}
                            </small>
                        @elseif($item->id_admin_travel)
                            <span class="badge bg-info text-dark">
                                Admin Travel
                            </span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    {{-- JADWAL --}}
                    <td>
                        @if($item->jadwal)
                            <div class="fw-semibold">
                                {{ \Carbon\Carbon::parse($item->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}
                            </div>
                            <small class="text-muted">
                                {{ $item->jadwal->jam_berangkat }} - {{ $item->jadwal->jam_tiba }}
                            </small>
                        @else
                            -
                        @endif
                    </td>

                    {{-- RUTE --}}
                    <td>
                        {{ optional(optional($item->jadwal)->jalur)->rute ?? '-' }}
                    </td>

                    {{-- KAPAL --}}
                    <td>
                        {{ optional(optional($item->jadwal)->kapal)->nama_kapal ?? '-' }}
                    </td>

                    {{-- KELAS --}}
                    <td class="text-center">
                        {{ $item->detailPenumpang->pluck('kelas')->unique()->implode(', ') ?: '-' }}
                    </td>

                    {{-- JUMLAH PENUMPANG --}}
                    <td class="text-center">
                    <span title="Jumlah Penumpang">
                        {{ $item->detailPenumpang->count() }}
                    </span>
                </td>


                    {{-- KATEGORI / JENIS TIKET --}}
                    <td class="text-center">
                        {{ $item->detailPenumpang->pluck('jenis_tiket')->unique()->implode(', ') ?: '-' }}
                    </td>

                    {{-- TOTAL HARGA --}}
                    <td class="text-center fw-bold text-success">
                        Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        @if($item->status === 'Confirmed')
                            <span class="badge bg-success px-3">Confirmed</span>
                        @elseif($item->status === 'Cancelled')
                            <span class="badge bg-danger px-3">Cancelled</span>
                        @else
                            <span class="badge bg-warning text-dark px-3">Pending</span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="text-center">
                        <a href="{{ route('pemesanan.pemesananpelayaran.show', $item->id_pemesanan) }}"
                           class="btn btn-sm btn-primary">
                            Detail
                        </a>
                    </td>

                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#pemesananPelayaranTable').DataTable({
        scrollX: true,
        autoWidth: false,
        responsive: false,
        columnDefs: [
            { targets: '_all', className: 'text-nowrap align-middle' }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>
@endpush
