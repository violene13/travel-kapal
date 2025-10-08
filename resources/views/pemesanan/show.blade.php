@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Pemesanan</h2>
    <div class="card shadow">
        <div class="card-body">
            {{-- Informasi Penumpang --}}
            <h5 class="mb-3">Informasi Penumpang</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $pemesanan->penumpang->nama_penumpang ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>
                        @if($pemesanan->penumpang && $pemesanan->penumpang->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($pemesanan->penumpang->tanggal_lahir)->translatedFormat('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Usia</th>
                    <td>
                        @if($pemesanan->penumpang && $pemesanan->penumpang->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($pemesanan->penumpang->tanggal_lahir)->age }} tahun
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>
                        @if($pemesanan->penumpang && $pemesanan->penumpang->gender)
                            {{ $pemesanan->penumpang->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>No. HP</th>
                    <td>{{ $pemesanan->penumpang->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $pemesanan->penumpang->alamat ?? '-' }}</td>
                </tr>
            </table>

            {{-- Informasi Jadwal --}}
            <h5 class="mt-4 mb-3">Informasi Jadwal</h5>
            <table class="table table-bordered">
                <tr>
                    <th>Tanggal Keberangkatan</th>
                    <td>
                        @if($pemesanan->jadwal && $pemesanan->jadwal->tanggal_berangkat)
                            {{ \Carbon\Carbon::parse($pemesanan->jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Jam</th>
                    <td>
                        {{ $pemesanan->jadwal->jam_berangkat ?? '-' }}
                        -
                        {{ $pemesanan->jadwal->jam_tiba ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Rute</th>
                   <td>
                {{ $pemesanan->jadwal->jalur->pelabuhanAsal->lokasi ?? '-' }}
                →
                {{ $pemesanan->jadwal->jalur->pelabuhanTujuan->lokasi ?? '-' }}
            </td>

                </tr>
                <tr>
                    <th>Kapal</th>
                    <td>{{ $pemesanan->jadwal->kapal->nama_kapal ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $pemesanan->jadwal->kelas_tiket ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Harga Tiket</th>
                    <td>
                        Rp {{ number_format($pemesanan->jadwal->harga_tiket ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($pemesanan->pembayaran && $pemesanan->pembayaran->status_bayar === 'Lunas')
                            <span class="badge bg-success">Lunas</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ $pemesanan->status ?? 'Pending' }}</span>
                        @endif
                    </td>
                </tr>
            </table>

            <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
