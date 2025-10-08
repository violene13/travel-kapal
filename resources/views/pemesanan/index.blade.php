@extends('layouts.app')

@section('title', 'Daftar Pemesanan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Pemesanan</h2>
    
    {{-- Wrapper biar tabel bisa digeser kiri-kanan --}}
    <div class="table-responsive">
        <table id="pemesananTable" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Penumpang</th>
                    <th>Tanggal Lahir</th>
                    <th>Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>No. HP</th>
                    <th>Jadwal</th>
                    <th>Rute</th>
                    <th>Kapal</th>
                    <th>Kelas</th>
                    <th>Harga Tiket</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemesanan as $item)
                <tr>
                    {{-- ID Pemesanan --}}
                    <td>#{{ str_pad($item->id_pemesanan, 5, '0', STR_PAD_LEFT) }}</td>

                    {{-- Nama Penumpang --}}
                    <td>{{ $item->penumpang->nama_penumpang ?? '-' }}</td>

                    {{-- Tanggal Lahir --}}
                    <td>{{ $item->penumpang->tanggal_lahir ?? '-' }}</td>

                    {{-- Usia --}}
                    <td>
                        @if($item->penumpang && $item->penumpang->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($item->penumpang->tanggal_lahir)->age }} tahun
                        @else
                            -
                        @endif
                    </td>

                    {{-- Jenis Kelamin --}}
                    <td>
                        @if($item->penumpang && $item->penumpang->gender)
                            {{ $item->penumpang->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        @else
                            -
                        @endif
                    </td>

                    {{-- Nomor HP --}}
                    <td>{{ $item->penumpang->no_hp ?? '-' }}</td>

                    {{-- Jadwal --}}
                    <td>
                        {{ \Carbon\Carbon::parse($item->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }} <br>
                        <small>{{ $item->jadwal->jam_berangkat }} - {{ $item->jadwal->jam_tiba }}</small>
                    </td>

                    {{-- Rute --}}
                    <td>{{ $item->jadwal->jalur->rute ?? '-' }}</td>

                    {{-- Kapal --}}
                    <td>{{ $item->jadwal->kapal->nama_kapal ?? '-' }}</td>

                    {{-- Kelas --}}
                    <td>{{ $item->jadwal->kelas_tiket ?? '-' }}</td>

                    {{-- Harga Tiket --}}
                    <td>Rp {{ number_format($item->jadwal->harga_tiket ?? 0, 0, ',', '.') }}</td>

                    {{-- Status --}}
                    <td>
                        @if($item->pembayaran && $item->pembayaran->status_bayar === 'Lunas')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $item->status ?? 'Pending' }}</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="text-nowrap">
                        <a href="{{ route('pemesanan.show', $item->id_pemesanan) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                        <a href="{{ route('pemesanan.edit', $item->id_pemesanan) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('pemesanan.destroy', $item->id_pemesanan) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pesanan ini?')">
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

@push('scripts')
<script>
$(document).ready(function() {
    $('#pemesananTable').DataTable({
        scrollX: true,       // aktifkan scroll horizontal
        autoWidth: false,    // biar kolom tetap sesuai isi
        responsive: false,   // matikan responsive biar ga collapse
        columnDefs: [
            { targets: '_all', className: 'text-nowrap' } // biar teks ga turun
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>
@endpush
@endsection
