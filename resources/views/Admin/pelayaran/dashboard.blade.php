@extends('layouts.adminpelayaran')

@section('title', 'Dashboard Admin')

@section('content')
<style>
/* ======== DASHBOARD STYLE ======== */
body {
    font-family: 'Inter', sans-serif;
  
}

/* Header Section */  
.dashboard-header {
    background: linear-gradient(135deg, #018688, #5395b4);
    color: white;
    border-radius: 15px;
    padding: 40px 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.dashboard-header h2 {
    font-weight: 600;
}

.dashboard-header p {
    opacity: 0.9;
    font-size: 1rem;
}

/* Wave Ornament */
.dashboard-header::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 80px;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff22" fill-opacity="1" d="M0,288L48,272C96,256,192,224,288,218.7C384,213,480,235,576,245.3C672,256,768,256,864,245.3C960,235,1056,213,1152,202.7C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
    background-size: cover;
    background-repeat: no-repeat;
}

/* Statistic Cards */
.stats-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-top: 30px;
}

.stat-card {
    color: #003B5C;
    border-radius: 12px;
    padding: 18px 15px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    text-align: center;
    transition: all 0.3s ease;
}

.stat-card h4 {
    font-size: 0.95rem;
    margin-bottom: 8px;
}

.stat-card h2 { 
    font-size: 1.4rem;
    font-weight: 700;
}

.stat-card i {
    font-size: 22px;
    opacity: 0.2;
}


/* Card Pastel Colors */
.card-blue    { background-color: #eae1b9; }
.card-green   { background-color: #c9e7c6; }
.card-yellow  { background-color: #FFF1B8; }
.card-purple  { background-color: #e8d1f5; }
.card-pink    { background-color: #facdcd; }

/* Chart Section */
.chart-section {
    margin-top: 40px;
    background: white;
    border-radius: 15px;
    padding: 25px 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.chart-section h5 {
    font-weight: 600;
    color: #003B5C;
    margin-bottom: 15px;
    text-align: center;
}

/* Wave Background Footer */
.footer-wave {
    margin-top: 40px;
    text-align: center;
    color: #003B5C;
    font-size: 0.9rem;
    opacity: 0.8;
}
</style>

<div class="content-wrapper mt-4">

    {{-- ====== HEADER ====== --}}
    <div class="dashboard-header">
        <h2>⚓ Welcome aboard, Admin!</h2>
        <p>Selamat bekerja — semoga hari ini penuh semangat berlayar 🚢</p>
    </div>

    <div class="stats-section">
    <div class="stat-card card-blue">
        <i class="fas fa-ticket-alt"></i>
        <h4>Total Tiket Terjual</h4>
        <h2>{{ $totalTiket }}</h2>
    </div>

    <div class="stat-card card-green">
        <i class="fas fa-ship"></i>
        <h4>Total Kapal</h4>
        <h2>{{ $totalKapal }}</h2>
    </div>

    <div class="stat-card card-yellow">
        <i class="fas fa-route"></i>
        <h4>Total Jalur</h4>
        <h2>{{ $totalJalur }}</h2>
    </div>

    <div class="stat-card card-purple">
        <i class="fas fa-anchor"></i>
        <h4>Total Pelabuhan</h4>
        <h2>{{ $totalPelabuhan }}</h2>
    </div>

    <div class="stat-card card-pink">
        <i class="fas fa-users"></i>
        <h4>Total Penumpang</h4>
        <h2>{{ $totalPenumpang }}</h2>
    </div>
</div>


   {{-- ====== CHART ====== --}}
<div class="chart-section">
    <h5>Distribusi Penjualan Tiket</h5>
    <div style="max-width: 450px; margin: 0 auto;">
        <canvas id="tiketChart" height="80"></canvas>
    </div>
</div>


    {{-- ====== FOOTER ORNAMENT ====== --}}
    <div class="footer-wave">
        🌊 Semangat menjaga pelayaran tetap aman dan nyaman 🌊
    </div>

</div>

{{-- ====== JS CHART ====== --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const grafikData = @json($grafikStatus);

const ctx = document.getElementById('tiketChart').getContext('2d');

new Chart(ctx, {
    type: 'polarArea',
    data: {
        labels: Object.keys(grafikData),
        datasets: [{
            data: Object.values(grafikData),
            backgroundColor: [
                'rgba(255, 193, 7, 0.8)',   // Pending
                'rgba(40, 167, 69, 0.8)',  // Confirmed
                'rgba(220, 53, 69, 0.8)'   // Cancelled
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

@endsection
