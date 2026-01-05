@extends('layouts.admintravel')

@section('title', 'Data Penumpang Travel')

@section('content')
<div class="container-fluid px-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary mb-0">Data Penumpang Travel</h2>
    <a href="{{ route('penumpang.penumpangtravel.create') }}" class="btn btn-success shadow-sm">
       Tambah Penumpang
    </a>
  </div>

  <div class="card shadow-sm border-0">
    <div class="card-body p-3">
      {{-- Bungkus tabel dengan div scroll --}}
      
        <table id="penumpangTable" class="table table-striped table-bordered align-middle mb-0">
          <thead class="table-dark text-center">
            <tr>
              <th>No</th>
              <th>Nama Penumpang</th>
              <th>Email</th>
              <th>No Handphone</th>
              <th>Alamat</th>
              <th>No KTP</th>
              <th>Gender</th>
              <th>Tanggal Lahir</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($penumpangs as $p)
              <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $p->nama_penumpang }}</td>
                <td>{{ $p->email }}</td>
                <td class="text-center">{{ $p->no_hp ?? '-' }}</td>
                <td class="text-start">{{ $p->alamat ?? '-' }}</td>
                <td class="text-center">{{ $p->no_ktp ?? '-' }}</td>
                <td class="text-center">
                  {{ $p->gender == 'L' ? 'Laki-laki' : ($p->gender == 'P' ? 'Perempuan' : '-') }}
                </td>
                <td class="text-center">
                  {{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') : '-' }}
                </td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('penumpang.penumpangtravel.edit', $p->id_penumpang) }}" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('penumpang.penumpangtravel.destroy', $p->id_penumpang) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="d-inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">Tidak ada data penumpang</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-end mt-4">
    <a href="{{ route('admin.travel.dashboard') }}" class="btn btn-primary">
      Kembali
    </a>
  </div>
</div>
@endsection

@push('styles')
<style>
  /* Bungkus scroll horizontal hanya pada tabel */
  .table-scroll-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    width: 100%;
  }

  /* Scrollbar rapi */
  .table-scroll-wrapper::-webkit-scrollbar {
    height: 10px;
  }
  .table-scroll-wrapper::-webkit-scrollbar-thumb {
    background: rgba(0,0,0,0.25);
    border-radius: 6px;
  }

  /* Pastikan tabel cukup lebar agar bisa di-scroll */
  #penumpangTable {
    min-width: 1300px;
    white-space: nowrap;
  }

  .table th, .table td {
    vertical-align: middle !important;
  }

  html, body {
    overflow-x: hidden;
  }
</style>
@endpush
@push('scripts') 
<script>
    $(document).ready(function() {
        $('#penumpangTable').DataTable({
            scrollX: true,
            autoWidth: false,

            // ⬇⬇ TAMBAHAN PAGINATE & ENTRI PER-HALAMAN
            pageLength: 10, // default tampil 10 data
            lengthMenu: [ [5, 10, 15, 20, -1], [5, 10, 15, 20, "Semua"] ],

            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },

            columnDefs: [
                {
                    targets: -1,
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
