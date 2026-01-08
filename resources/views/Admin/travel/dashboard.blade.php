@extends('layouts.admintravel')

@section('title', 'Dashboard Admin')

@section('content')
<style>
  body {
    background-color: #f7f9fc;
  }

  .dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
    background: linear-gradient(135deg, #7dd3fc, #a78bfa);
    color: #fff;
    padding: 30px 40px;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }

  .dashboard-header h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
  }

  .dashboard-header p {
    margin: 8px 0 0;
    font-size: 1.1rem;
    opacity: 0.9;
  }

  .dashboard-header img {
    width: 120px;
    opacity: 0.95;
  }

  /* grid ringkasan kecil */
  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin-top: 10px;
  }

  .card-small {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    border-radius: 15px;
    background: linear-gradient(135deg, #ecfeff, #f5f3ff);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .card-small:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
  }

  .card-small i {
    font-size: 2rem;
    color: #6366f1;
    background: rgba(99, 102, 241, 0.1);
    padding: 10px;
    border-radius: 10px;
  }

  .card-small p {
    margin: 0;
    color: #374151;
  }

  .value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e3a8a;
  }

  .charts-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 25px;
    margin-top: 40px;
  }

  .chart-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07);
  }

  .chart-card h3 {
    margin-bottom: 15px;
    color: #374151;
    text-align: center;
  }
</style>

<div class="dashboard-header">
  <div>
    <h1>Selamat Datang di Dashboard!</h1>
    <p>Semoga harimu menyenangkan dan produktif 🚢</p>
  </div>
  
</div>

<div class="grid">
  <div class="card-small">
    <i class="bi bi-ticket-perforated"></i>
    <div>
      <p>Pemesanan</p>
      <p class="value">{{ $jumlahPemesanan }}</p>
    </div>
  </div>

  <div class="card-small">
    <i class="bi bi-people"></i>
    <div>
      <p>Data Penumpang</p>
      <p class="value">{{ $jumlahPenumpang }}</p>
    </div>
  </div>
</div>

<div class="charts-container">
  <div class="chart-card">
    <h3>Grafik Pemesanan per Bulan</h3>
    <canvas id="chartPemesanan"></canvas>
  </div>

  <div class="chart-card">
    <h3>Grafik Penumpang per Bulan</h3>
    <canvas id="chartPenumpang"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Grafik Pemesanan
  new Chart(document.getElementById('chartPemesanan'), {
    type: 'line',
    data: {
      labels: {!! json_encode($bulanPemesanan ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) !!},
      datasets: [{
        label: 'Jumlah Pemesanan',
        data: {!! json_encode($dataPemesanan ?? [4, 6, 8, 10, 7, 12]) !!},
        borderColor: '#6366f1',
        backgroundColor: 'rgba(99,102,241,0.2)',
        fill: true,
        tension: 0.3,
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } }
    }
  });

  // Grafik Penumpang
  new Chart(document.getElementById('chartPenumpang'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($bulanPenumpang ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) !!},
      datasets: [{
        label: 'Jumlah Penumpang',
        data: {!! json_encode($dataPenumpang ?? [3, 5, 9, 6, 8, 10]) !!},
        backgroundColor: 'rgba(14,165,233,0.4)',
        borderColor: '#0ea5e9',
        borderWidth: 1.5,
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true } }
    }
  });
</script>
@endsection
