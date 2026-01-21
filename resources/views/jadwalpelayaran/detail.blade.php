@extends('layouts.pengguna')

@section('title', 'Detail Pelayaran')

@section('content')
<div class="container py-4">
    <style>
#loginModal .modal-content {
    animation: fadeIn 0.25s ease-in-out;
}
#loginModal input:focus {
    border-color: #00c2a8;
    box-shadow: 0 0 6px rgba(0,194,168,0.3);
}
#loginModal .btn:hover {
    background: linear-gradient(90deg, #00c2a8, #0099cc);
    transform: translateY(-1px);
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>

    {{-- GAMBAR KAPAL --}}
    @if($jadwal->kapal->gambar_kapal ?? false)
    <div class="card border-0 shadow-sm mb-4">
        <img src="{{ asset('images/kapal/' . $jadwal->kapal->gambar_kapal) }}"
             class="w-100"
             style="height:280px;object-fit:cover;border-radius:6px;">
    </div>
    @endif

    <div class="card shadow-sm border-0 p-4">

        <h4 class="fw-bold mb-3">{{ $jadwal->kapal->nama_kapal }}</h4>

        {{-- PILIH KELAS --}}
        @if(count($hargaPerKelas))
        <div class="mb-4">
            <label class="fw-bold mb-1">Pilih Kelas</label>
            <select id="kelasSelect" class="form-select" onchange="updateHarga()">
                @foreach($hargaPerKelas as $kelas => $x)
                    <option value="{{ $kelas }}">{{ $kelas }}</option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- INFO JADWAL --}}
        <div class="row text-center mb-4">

            {{-- ASAL --}}
            <div class="col-4">
                <h5>{{ date('h:i A', strtotime($jadwal->jam_berangkat)) }}</h5>
                <p>{{ date('j F Y', strtotime($jadwal->tanggal_berangkat)) }}</p>
                <small class="text-muted">
                    {{ $jadwal->jalur->pelabuhanAsal->lokasi }} <br>
                    Pelabuhan {{ $jadwal->jalur->pelabuhanAsal->nama_pelabuhan }}
                </small>
            </div>

            {{-- DURASI --}}
            <div class="col-4 d-flex align-items-center justify-content-center">
                <p class="fw-bold">{{ $jadwal->durasi }}</p>
            </div>

            {{-- TUJUAN --}}
            <div class="col-4">
                <h5>{{ date('h:i A', strtotime($jadwal->jam_tiba)) }}</h5>
                <p>{{ date('j F Y', strtotime($jadwal->tanggal_tiba)) }}</p>
                <small class="text-muted">
                    {{ $jadwal->jalur->pelabuhanTujuan->lokasi }} <br>
                    Pelabuhan {{ $jadwal->jalur->pelabuhanTujuan->nama_pelabuhan }}
                </small>
            </div>
        </div>

        <hr>

        {{-- HARGA --}}
        <div class="mb-3">
            <h6 class="fw-bold mb-2">Harga Tiket</h6>

            <div class="d-flex justify-content-between">
                <span>Dewasa</span>
                <span>Rp <span id="harga-dewasa">0</span></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Anak</span>
                <span>Rp <span id="harga-anak">0</span></span>
            </div>

            <div class="d-flex justify-content-between">
                <span>Bayi</span>
                <span>Rp <span id="harga-bayi">0</span></span>
            </div>
        </div>

        <hr>

        <div class="text-center">
          @if(auth()->check() && auth()->user()->role === 'penumpang')
    <a href="{{ route('pemesanan.pemesananpengguna.create', $jadwal->id_jadwal) }}"
       class="btn btn-primary px-5">
        Pesan Sekarang
    </a>
     <a href="{{ route('jadwal.lengkap', $jadwal->id_jadwal) }}"
       class="btn btn-outline-secondary px-5">
        Kembali
    </a>
@else
    <button class="btn btn-primary px-5" data-bs-toggle="modal" data-bs-target="#loginModal">
        Pesan Sekarang
    </button>
@endif

        </div>

    </div>
</div>

{{-- JS HARGA --}}
<script>
const hargaPerKelas = @json($hargaPerKelas);

function updateHarga() {
    const kelas = document.getElementById('kelasSelect')?.value;
    if (!kelas) return;

    const harga = hargaPerKelas[kelas] ?? {};

    document.getElementById('harga-dewasa').innerText =
        (harga.dewasa ?? 0).toLocaleString('id-ID');

    document.getElementById('harga-anak').innerText =
        (harga.anak ?? 0).toLocaleString('id-ID');

    document.getElementById('harga-bayi').innerText =
        (harga.bayi ?? 0).toLocaleString('id-ID');
}

updateHarga();
</script>

@endsection
