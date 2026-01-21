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

    <div class="table-responsive">
        <table id="pemesananTable" class="table table-striped table-bordered nowrap w-100">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Pemesan</th>
                    <th>Jadwal</th>
                    <th>Rute</th>
                    <th>Kapal</th>
                    <th>Kelas</th>
                    <th>Jml Pen</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($pemesanan as $item)
                <tr>

                    {{-- ID --}}
                    <td class="text-center fw-semibold">
                        #{{ str_pad($item->id_pemesanan, 5, '0', STR_PAD_LEFT) }}
                    </td>

                    {{-- PEMESAN --}}
                    <td>
                        {{ optional($item->penumpang)->nama_penumpang ?? '-' }}
                        <br>
                        <small class="text-muted">
                            {{ optional($item->penumpang)->no_hp ?? '' }}
                        </small>
                    </td>

                    {{-- JADWAL --}}
                    <td>
                        @if($item->jadwal)
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}
                            <br>
                            <small class="text-muted">
                                {{ $item->jadwal->jam_berangkat }} - {{ $item->jadwal->jam_tiba }}
                            </small>
                        @else
                            -
                        @endif
                    </td>

                    {{-- RUTE --}}
                    <td>{{ optional(optional($item->jadwal)->jalur)->rute ?? '-' }}</td>

                    {{-- KAPAL --}}
                    <td>{{ optional(optional($item->jadwal)->kapal)->nama_kapal ?? '-' }}</td>

                    {{-- KELAS --}}
                    <td class="text-center">
                        {{ $item->detailPenumpang->pluck('kelas')->unique()->implode(', ') ?: '-' }}
                    </td>

                    {{-- JUMLAH PENUMPANG --}}
                    <td class="text-center">
                        <span class="badge bg-info">
                            {{ $item->detailPenumpang->count() }} org
                        </span>
                    </td>

                    {{-- TOTAL --}}
                    <td class="text-end fw-bold text-success">
                        Rp {{ number_format($item->total_harga ?? 0, 0, ',', '.') }}
                    </td>

                    {{-- STATUS --}}
                    <td class="text-center">
                        <div class="status-wrapper">
                            <span class="badge
                                @if($item->status === 'Confirmed') bg-success
                                @elseif($item->status === 'Cancelled') bg-danger
                                @else bg-warning text-dark @endif
                                status-badge" style="cursor:pointer">
                                {{ $item->status }}
                            </span>

                            <form action="{{ route('pemesanan.pemesanantravel.updateStatus', $item->id_pemesanan) }}"
                                  method="POST" class="status-form d-none">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm status-select">
                                    <option value="Pending" {{ $item->status=='Pending'?'selected':'' }}>Pending</option>
                                    <option value="Confirmed" {{ $item->status=='Confirmed'?'selected':'' }}>Confirmed</option>
                                    <option value="Cancelled" {{ $item->status=='Cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                            </form>
                        </div>
                    </td>

                    {{-- AKSI --}}
                    <td class="text-nowrap text-center">
                        <a href="{{ route('pemesanan.pemesanantravel.show', $item->id_pemesanan) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('pemesanan.pemesanantravel.edit', $item->id_pemesanan) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('pemesanan.pemesanantravel.destroy', $item->id_pemesanan) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus data ini?')">
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
$(function () {
    $('#pemesananTable').DataTable({
        scrollX: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });

    document.querySelectorAll('.status-wrapper').forEach(wrapper => {
        let badge = wrapper.querySelector('.status-badge');
        let form = wrapper.querySelector('.status-form');
        let select = wrapper.querySelector('.status-select');

        badge.addEventListener('click', () => {
            badge.classList.add('d-none');
            form.classList.remove('d-none');
        });

        select.addEventListener('change', () => form.submit());
    });
});
</script>
@endpush
