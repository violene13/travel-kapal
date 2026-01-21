@extends('layouts.pengguna')

@section('title', 'Pemesanan Saya - Sealine')

@section('content')
<div class="container py-5">
 <h4 class="fw-bold mb-4">Histori Pemesanan</h4>
@if ($pemesanan->isEmpty())
    <div class="text-center mt-5">
        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076500.png" width="140" class="mb-3 opacity-75">
        <h5 class="fw-semibold">Belum Ada Pemesanan</h5>
        <p class="text-muted">Silakan pilih jadwal untuk melakukan pemesanan tiket.</p>

        <a href="{{ route('jadwal.lengkap') }}" class="btn btn-primary px-4 mt-3">
            Cari Jadwal
        </a>
    </div>
@else

<div class="card shadow-sm border-0">
    <div class="card-body p-0">

        <table class="table table-hover align-middle mb-0">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="py-3 ps-4">Kode</th>
                    <th>Rute</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($pemesanan as $item)
                <tr>
                    <td class="ps-4 fw-semibold text-primary">
                        #{{ $item->id_pemesanan }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            {{ $item->jadwal->jalur->pelabuhanAsal->lokasi ?? '-' }}
                            →
                            {{ $item->jadwal->jalur->pelabuhanTujuan->lokasi ?? '-' }}
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-ship"></i>
                            {{ $item->jadwal->kapal->nama_kapal }}
                        </small>
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($item->jadwal->tanggal_berangkat)->format('d M Y') }}
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-clock"></i>
                            {{ \Carbon\Carbon::parse($item->jadwal->jam_berangkat)->format('H:i') }} WIB
                        </small>
                    </td>

                    <td>
                        @if ($item->status === 'Pending')
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Pending</span>
                        @elseif ($item->status === 'Confirmed')
                            <span class="badge bg-success rounded-pill px-3 py-2">Confirmed</span>
                        @else
                            <span class="badge bg-danger rounded-pill px-3 py-2">Cancelled</span>
                        @endif
                    </td>

                   <td class="text-end pe-4">

    {{-- DETAIL --}}
    <a href="{{ route('pemesanan.pemesananpengguna.show', $item->id_pemesanan) }}"
       class="btn btn-primary btn-sm mb-1">
        <i class="bi bi-eye"></i> Detail
    </a>
    <a href="{{ route('pemesanan.eticket', $item->id_pemesanan) }}"
       class="btn btn-warning btn-sm mb-1">
        <i class="bi bi-printer"></i> cetak E-Ticket
    </a>

    {{-- BATAL (PENDING) --}}
    @if ($item->status === 'Pending')
        <form id="batal-form-{{ $item->id_pemesanan }}"
              action="{{ route('pemesanan.pemesananpengguna.batal', $item->id_pemesanan) }}"
              method="POST"
              class="d-inline">
            @csrf
            @method('PUT')

            <button type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="confirmBatal({{ $item->id_pemesanan }})">
                <i class="bi bi-x-circle"></i> Batalkan
            </button>
        </form>
    @endif

    {{-- HAPUS (CANCELLED) --}}
    @if ($item->status === 'Cancelled')
        <form id="hapus-form-{{ $item->id_pemesanan }}"
             action="{{ route('pemesanan.pemesananpengguna.hapus', $item->id_pemesanan) }}"

              method="POST"
              class="d-inline">
            @csrf
            @method('DELETE')

            <button type="button"
                    class="btn btn-outline-danger btn-sm"
                    onclick="confirmHapus({{ $item->id_pemesanan }})">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </form>
    @endif

</td>

            @endforeach
            </tbody>
        </table>

    </div>
</div>

<div class="mt-4">
    {{ $pemesanan->links() }}
</div>

@endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmBatal(id) {
    Swal.fire({
        title: 'Batalkan Pemesanan?',
        text: 'Pemesanan yang dibatalkan tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('batal-form-' + id).submit();
        }
    });
}

function confirmHapus(id) {
    Swal.fire({
        title: 'Hapus Pemesanan?',
        text: 'Data pemesanan akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6c757d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('hapus-form-' + id).submit();
        }
    });
}
</script>
@endsection