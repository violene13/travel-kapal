@extends('layouts.adminpelayaran')

@section('title', 'Dashboard Pelayaran')

@section('content')
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
      <h1>WELCOME ADMIN</h1> <br>
      <p>Selamat Bekerja, Tetap Semangat !</p>
    </div>
    <img src="{{ asset('images/ship.png') }}" alt="Ship Illustration" style="width:150px;">
  </div>

  {{-- Aktivitas Terbaru --}}
  <div class="card" style="padding:20px; background:#fff; border-radius:10px; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
    <h2>Aktivitas Terbaru</h2>
    <table class="table" style="width:100%; border-collapse:collapse; margin-top:15px;">
      <thead>
        <tr style="background:#f4f4f4;">
          <th style="padding:10px; border:1px solid #ddd;">Jenis</th>
          <th style="padding:10px; border:1px solid #ddd;">Detail</th>
          <th style="padding:10px; border:1px solid #ddd;">Tanggal</th>
        </tr>
      </thead>
      <tbody>
        @forelse($aktivitas ?? [] as $a)
          <tr>
            <td style="padding:10px; border:1px solid #ddd;">{{ $a->jenis }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $a->detail }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $a->tanggal }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="3" style="text-align:center; padding:15px;">Belum ada aktivitas terbaru.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    </div>

    {{-- Card Statistik --}}
            <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>Total Kapal</h5>
                <h3>{{ $totalKapal }}</h3>
            </div>
        </div>
         <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>Total Pelabuhan </h5>
                <h3>{{ $totalPelabuhan }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h5>Total Jalur</h5>
                <h3>{{ $totalJalur }}</h3>
            </div>
        </div>

        </div>

    </div>
  </div>
@endsection
