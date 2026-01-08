@extends('layouts.pengguna')

@section('title', 'Pemesanan Saya - Sealine')

@section('content')
<div class="container py-5">

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
                        <th class="py-3 ps-4">Kode Pemesanan</th>
                        <th>Rute</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pemesanan as $item)
                        <tr>
                            <td class="ps-4 fw-semibold">
                                #{{ $item->id_pemesanan }}
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $item->jadwal->asalPelabuhan->nama_pelabuhan }}
                                    →
                                    {{ $item->jadwal->tujuanPelabuhan->nama_pelabuhan }}
                                </div>
                                <small class="text-muted">
                                    {{ $item->jadwal->kapal->nama_kapal }}
                                </small>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($item->jadwal->tanggal_berangkat)->format('d M Y') }}
                                <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->jadwal->jam_berangkat)->format('H:i') }} WIB
                                </small>
                            </td>

                            <td>
                                @if ($item->status == 'Pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                @elseif ($item->status == 'Confirmed')
                                    <span class="badge bg-success px-3 py-2">Confirmed</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">Cancelled</span>
                                @endif
                            </td> 

                            <td class="text-end pe-4">
                                <a href="{{ route('pemesanan.pemesananpengguna.show', $item->id_pemesanan) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
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
@endsection
