@extends('layouts.adminpelayaran')

@section('title', 'Daftar Pemesanan Pelayaran')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold text-primary mb-4">Daftar Pemesanan Pelayaran</h2>

    {{-- Wrapper tabel agar bisa discroll horizontal --}}
    <div class="table-responsive">
        <table id="pemesananPelayaranTable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead class="table-success table-header">
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Penumpang</th>
                    <th>No. HP</th>
                    <th>Jenis Kelamin</th>
                    <th>Usia</th>
                    <th>Jadwal</th>
                    <th>Rute</th>
                    <th>Kapal</th>
                    <th>Kelas</th>
                    <th>Harga Tiket</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pemesanan as $item)
                <tr>
                    {{-- ID Pemesanan --}}
                    <td>#{{ str_pad($item->id_pemesanan, 5, '0', STR_PAD_LEFT) }}</td>

                    {{-- Nama Penumpang --}}
                    <td>{{ $item->penumpang->nama_penumpang ?? '-' }}</td>

                    {{-- Nomor HP --}}
                    <td>{{ $item->penumpang->no_hp ?? '-' }}</td>

                    {{-- Gender --}}
                    <td>
                        @if($item->penumpang?->gender === 'L')
                            Laki-laki
                        @elseif($item->penumpang?->gender === 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </td>

                    {{-- Usia --}}
                    <td>
                        @if($item->penumpang?->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($item->penumpang->tanggal_lahir)->age }} th
                        @else
                            -
                        @endif
                    </td>

                    {{-- Jadwal --}}
                    <td>
                        @if($item->jadwal)
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}
                            <br>
                            <small>{{ $item->jadwal->jam_berangkat }} - {{ $item->jadwal->jam_tiba }}</small>
                        @else
                            -
                        @endif
                    </td>

                    {{-- Rute --}}
                    <td>{{ $item->jadwal->jalur->rute ?? '-' }}</td>

                    {{-- Kapal --}}
                    <td>{{ $item->jadwal->kapal->nama_kapal ?? '-' }}</td>

                    {{-- Kelas --}}
                    <td>{{ $item->jadwal->kelas ?? '-' }}</td>

                    {{-- Harga --}}
                    <td>Rp {{ number_format($item->jadwal->harga ?? 0, 0, ',', '.') }}</td>

                    {{-- Status --}}
                    <td>
                        @php $status = strtolower($item->status ?? 'pending'); @endphp

                        @if($status === 'confirmed')
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($status === 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ ucfirst($status) }}</span>
                        @endif
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
$(document).ready(function() {
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
