@extends('layouts.app')

@section('title', 'Tambah Pemesanan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tambah Pemesanan</h2>

    <form action="{{ route('pemesanan.store') }}" method="POST">
        @csrf

        {{-- Pilih Jadwal --}}
        <div class="mb-4">
            <label for="jadwal_id" class="form-label fw-bold">Jadwal Kapal</label>
            <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                <option value="">-- Pilih Jadwal --</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id_jadwal }}"
                        data-tanggal="{{ \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->translatedFormat('d F Y') }}"
                        data-jam="{{ $jadwal->jam_berangkat }} - {{ $jadwal->jam_tiba }}"
                        data-rute="{{ $jadwal->jalur->pelabuhan_asal->nama_pelabuhan }} → {{ $jadwal->jalur->pelabuhan_tujuan->nama_pelabuhan }}"
                        data-kapal="{{ $jadwal->kapal->nama_kapal }}"
                        data-kelas="{{ $jadwal->kelas_tiket }}">
                        {{ \Carbon\Carbon::parse($jadwal->tanggal_berangkat)->translatedFormat('d M Y') }}
                        | {{ $jadwal->jam_berangkat }} - {{ $jadwal->jam_tiba }}
                        | {{ $jadwal->jalur->pelabuhan_asal->nama_pelabuhan }} → {{ $jadwal->jalur->pelabuhan_tujuan->nama_pelabuhan }}
                        | Kapal: {{ $jadwal->kapal->nama_kapal }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Detail Jadwal (muncul setelah dipilih) --}}
        <div id="jadwalDetail" class="card p-3 mb-4 shadow-sm" style="display: none;">
            <h5 class="fw-bold mb-3">🛳 Detail Jadwal</h5>
            <table class="table table-borderless">
                <tr>
                    <th width="200">Tanggal</th>
                    <td id="detailTanggal"></td>
                </tr>
                <tr>
                    <th>Jam</th>
                    <td id="detailJam"></td>
                </tr>
                <tr>
                    <th>Rute</th>
                    <td id="detailRute"></td>
                </tr>
                <tr>
                    <th>Kapal</th>
                    <td id="detailKapal"></td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td id="detailKelas"></td>
                </tr>
            </table>
        </div>

        {{-- Data Penumpang --}}
        <div id="penumpangWrapper">
            <div class="card p-3 mb-3 shadow-sm">
                <h5 class="fw-bold">Penumpang #1</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Penumpang</label>
                        <input type="text" name="penumpang[0][nama_penumpang]" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>No. HP</label>
                        <input type="text" name="penumpang[0][no_hp]" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="penumpang[0][tanggal_lahir]" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat</label>
                        <textarea name="penumpang[0][alamat]" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Jenis Identitas</label>
                        <select name="penumpang[0][jenis_identitas]" class="form-select" required>
                            <option value="">Pilih Jenis Identitas</option>
                            <option value="KTP">KTP</option>
                            <option value="SIM">SIM</option>
                            <option value="Passport">Passport</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>No. Identitas</label>
                        <input type="text" name="penumpang[0][no_identitas]" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Tambah Penumpang --}}
        <button type="button" id="addPenumpang" class="btn btn-outline-primary mb-3">+ Tambah Penumpang</button>

        {{-- Tombol Simpan --}}
        <div class="d-flex justify-content-end">
            <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary me-2">⬅ Kembali</a>
            <button type="submit" class="btn btn-success">💾 Simpan Pemesanan</button>
        </div>
    </form>
</div>

{{-- Script untuk detail jadwal & tambah penumpang --}}
<script>
document.getElementById('jadwal_id').addEventListener('change', function() {
    let option = this.options[this.selectedIndex];
    if(option.value){
        document.getElementById('jadwalDetail').style.display = 'block';
        document.getElementById('detailTanggal').innerText = option.dataset.tanggal;
        document.getElementById('detailJam').innerText = option.dataset.jam;
        document.getElementById('detailRute').innerText = option.dataset.rute;
        document.getElementById('detailKapal').innerText = option.dataset.kapal;
        document.getElementById('detailKelas').innerText = option.dataset.kelas;
    } else {
        document.getElementById('jadwalDetail').style.display = 'none';
    }
});

let count = 1;
document.getElementById('addPenumpang').addEventListener('click', function(){
    let wrapper = document.getElementById('penumpangWrapper');
    let card = document.createElement('div');
    card.classList.add('card','p-3','mb-3','shadow-sm');
    card.innerHTML = `
        <h5 class="fw-bold">Penumpang #${count+1}</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nama Penumpang</label>
                <input type="text" name="penumpang[${count}][nama_penumpang]" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>No. HP</label>
                <input type="text" name="penumpang[${count}][no_hp]" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Alamat</label>
                <textarea name="penumpang[${count}][alamat]" class="form-control" required></textarea>
            </div>
            <div class="col-md-3 mb-3">
                <label>Jenis Identitas</label>
                <select name="penumpang[${count}][jenis_identitas]" class="form-select" required>
                    <option value="">Pilih Jenis Identitas</option>
                    <option value="KTP">KTP</option>
                    <option value="SIM">SIM</option>
                    <option value="Passport">Passport</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label>No. Identitas</label>
                <input type="text" name="penumpang[${count}][no_identitas]" class="form-control" required>
            </div>
        </div>
    `;
    wrapper.appendChild(card);
    count++;
});
</script>
@endsection
