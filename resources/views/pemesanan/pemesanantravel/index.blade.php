@extends('layouts.admintravel')

@section('title', 'Daftar Pemesanan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold text-primary mb-0">Daftar Pemesanan</h2>
        <a href="{{ route('pemesanan.pemesanantravel.create') }}" class="btn btn-primary">
          Tambah Pemesanan
        </a>
    </div>

    {{-- Wrapper tabel agar bisa discroll horizontal --}}
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
                        @if(!empty($item->penumpang?->tanggal_lahir))
                            {{ \Carbon\Carbon::parse($item->penumpang->tanggal_lahir)->age }} tahun
                        @else
                            -
                        @endif
                    </td>

                    {{-- Jenis Kelamin --}}
                    <td>
                        @if($item->penumpang?->gender === 'L')
                            Laki-laki
                        @elseif($item->penumpang?->gender === 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </td>

                    {{-- Nomor HP --}}
                    <td>{{ $item->penumpang->no_hp ?? '-' }}</td>

                    {{-- Jadwal --}}
                    <td>
                        @if($item->jadwal)
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}<br>
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

                    {{-- Harga Tiket --}}
                    <td>Rp {{ number_format($item->jadwal->harga ?? 0, 0, ',', '.') }}</td>

                    {{-- Status --}}
                    <td>
                        <div class="status-wrapper" data-id="{{ $item->id_pemesanan }}">

                            {{-- Badge --}}
                            <span class="status-badge badge
                                @if($item->status == 'Confirmed') bg-success
                                @elseif($item->status == 'Cancelled') bg-danger
                                @else bg-warning text-dark @endif
                            " style="cursor:pointer;">
                                {{ $item->status }}
                            </span>

                            {{-- Dropdown (hidden default) --}}
                            <form action="{{ route('pemesanan.pemesanantravel.updateStatus', $item->id_pemesanan) }}"
                                  method="POST" class="status-form d-none">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="form-select form-select-sm status-select">
                                    <option value="Pending"   {{ $item->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Confirmed" {{ $item->status === 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="Cancelled" {{ $item->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>

                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td class="text-nowrap">
                        <a href="{{ route('pemesanan.pemesanantravel.show', $item->id_pemesanan) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('pemesanan.pemesanantravel.edit', $item->id_pemesanan) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('pemesanan.pemesanantravel.destroy', $item->id_pemesanan) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pesanan ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
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
    $('#pemesananTable').DataTable({
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


// === Inline Edit Status ===
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".status-wrapper").forEach(function (wrapper) {
        let badge = wrapper.querySelector(".status-badge");
        let form = wrapper.querySelector(".status-form");
        let select = wrapper.querySelector(".status-select");

        // Klik badge → tampilkan select
        badge.addEventListener("click", function () {
            badge.classList.add("d-none");
            form.classList.remove("d-none");
        });

        // Saat pilih status → submit
        select.addEventListener("change", function () {
            form.submit();
        });
    });
});
</script>
@endpush
