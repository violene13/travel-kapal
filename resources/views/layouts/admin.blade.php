<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin')</title>

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
      {{-- ✅ Dashboard Admin Travel --}}
      <a href="{{ route('admin.travel.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>

      {{-- ✅ Data Penumpang --}}
      <a href="{{ route('penumpang.index') }}"><i class="bi bi-people"></i> Data Penumpang</a>

      {{-- ✅ Pemesanan --}}
      <a href="{{ route('pemesanan.index') }}"><i class="bi bi-ticket-perforated"></i> Pemesanan</a>

      {{-- ✅ Perubahan & Pembatalan --}}
      <a href="{{ route('perubahan_pembatalan.index') }}"><i class="bi bi-arrow-repeat"></i> Perubahan & Pembatalan</a>

      {{-- ✅ Laporan (sementara kosong) --}}
      <a href="#"><i class="bi bi-graph-up"></i> Laporan</a>
    </nav>

    <!-- ✅ Logout pakai form -->
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="logout">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </aside>

  <!-- Main Content -->
  <main class="content">
    @yield('content')
  </main>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <i class="bi bi-ship"></i>
      <span>ADMIN SYSTEM</span>
    </div>

    <nav>
      {{-- ✅ Dashboard Admin Pelayaran --}}
      <a href="{{ route('admin.pelayaran.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>

      {{-- ✅ jalur pelayaran --}}
      <a href="{{ route('jalur.index') }}"><i class="bi bi-people"></i> Jalur Pelayaran</a>

      {{-- ✅ data kapal --}}
      <a href="{{ route('kapal.index') }}"><i class="bi bi-ticket-perforated"></i> Data Kapal</a>

      {{-- ✅ data pelabuhan --}}
      <a href="{{ route('pelabuhan.index') }}"><i class="bi bi-arrow-repeat"></i> Data Pelabuhan</a>

      {{-- ✅ jadwal pelayaran --}}
       <a href="{{ route('jadwal.index') }}"><i class="bi bi-arrow-repeat"></i> Jadwal Pelayaran</a>
      
       {{-- ✅ Laporan (sementara kosong) --}}
      <a href="#"><i class="bi bi-graph-up"></i> Laporan</a>
    </nav>

    <!-- ✅ Logout pakai form -->
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="logout">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </aside>

  <!-- Main Content -->
  <main class="content">
    @yield('content')
  </main>

</body>
</html>
