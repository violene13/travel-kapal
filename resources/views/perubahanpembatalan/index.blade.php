@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Perubahan & Pembatalan Pesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Penumpang</th>
                    <th>Jadwal</th>
                    <th>Rute</th>
                    <th>No HP</th>
                    <th>Kapal</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nama_penumpang }}</td>
                        <td>{{ $d->jadwal }}</td>
                        <td>{{ $d->rute }}</td>
                        <td>{{ $d->no_hp }}</td>
                        <td>{{ $d->kapal }}</td>
                        <td>{{ $d->kelas }}</td>
                        <td>{{ $d->status }}</td>
                        <td>{{ ucfirst($d->tipe) }}</td>
                        <td>
                            @if($d->status !== 'Diproses')
                                <a href="{{ route('perubahan_pembatalan.process', $d->id_pemesanan) }}" 
                                   class="btn btn-sm btn-success">Proses</a>
                            @endif
                            <form action="{{ route('perubahan_pembatalan.destroy', $d->id_pemesanan) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
