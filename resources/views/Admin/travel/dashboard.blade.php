<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #F4F8FB;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color: #003B5C;
      color: white;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      box-shadow: 2px 0 8px rgba(0,0,0,0.2);
    }

    .sidebar .logo {
      text-align: center;
      padding: 20px 0;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .sidebar .logo i {
      font-size: 32px;
      margin-bottom: 10px;
      display: block;
    }

    .sidebar .logo span {
      font-weight: bold;
      font-size: 14px;
      text-transform: uppercase;
    }

    .sidebar nav {
      flex: 1;
      padding: 20px 0;
    }

    .sidebar nav a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      color: white;
      text-decoration: none;
      transition: background 0.3s;
    }

    .sidebar nav a:hover {
      background-color: #025680;
      border-radius: 6px;
    }

    .sidebar form {
      margin: 20px;
    }

    .sidebar button.logout {
      width: 100%;
      padding: 12px 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      color: white;
      background: none;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-align: left;
      transition: background 0.3s;
    }

    .sidebar button.logout:hover {
      background-color: #025680;
    }

    /* Main content */
    .content {
      flex: 1;
      padding: 30px;
    }

    .content h1 {
      color: #123c7a;
      margin: 0;
    }

    .content p {
      margin-top: 5px;
      color: #1d4e89;
    }

    .card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .card-small {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .card-small i {
      font-size: 28px;
      color: #123c7a;
    }

    .card-small p {
      margin: 0;
    }

    .card-small .value {
      font-weight: bold;
      font-size: 20px;
      color: #123c7a;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }

    table th {
      text-align: left;
    }

    table tr:hover {
      background: #f9f9f9;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="bi bi-ship"></i>
      <span>ADMIN SYSTEM</span>
    </div>

    <nav>
      <a href="{{ route('dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
      <a href="{{ route('penumpang.index') }}"><i class="bi bi-people"></i> Data Penumpang</a>
      <a href="{{ route('pemesanan.index') }}"><i class="bi bi-ticket-perforated"></i> Pemesanan</a>
      <a href="#"><i class="bi bi-arrow-repeat"></i> Perubahan & Pembatalan</a>
      <a href="#"><i class="bi bi-graph-up"></i> Laporan</a>
    </nav>

    <!-- Logout pakai form -->
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="logout">
        <i class="bi bi-box-arrow-right"></i> Logout <span style="padding: 15px; "></span>
      </button>
    </form>
  </aside>

  <!-- Main Content -->
  <main class="content">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
      <div>
        <h1>WELCOME ABOARD</h1> <br>
        <p>Selamat Bekerja!</p>
      </div>
      <img src="{{ asset('images/ship.png') }}" alt="Ship Illustration" style="width:150px;">
    </div>

   <div class="card">
  <h2>Aktivitas Terbaru</h2>
  <table>
    <thead>
      <tr>
        <th>Jenis</th>
        <th>Detail</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($pemesanan as $p)
        <tr>
          <td>Pemesanan</td>
          <td>{{ $p->id_pemesanan }} - {{ $p->nama_penumpang ?? 'N/A' }}</td>
          <td>
            @if ($p->created_at)
              {{ $p->created_at->format('Y-m-d H:i') }}
            @elseif (!empty($p->tanggal_pemesanan))
              {{ $p->tanggal_pemesanan }}
            @else
              -
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" style="text-align:center; color:#888; padding: 12px;">
            Belum ada aktivitas
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>


    <div class="grid">
      <div class="card card-small">
        <i class="bi bi-ticket-perforated"></i>
        <div>
          <p>Pemesanan</p>
          <p class="value">{{ $jumlahPemesanan }}</p>
        </div>
      </div>

      <div class="card card-small">
        <i class="bi bi-people"></i>
        <div>
          <p>Data Penumpang</p>
          <p class="value">{{ $jumlahPenumpang }}</p>
        </div>
      </div>
    </div>
  </main>

</body>
</html>

BLADE DASHBOARD