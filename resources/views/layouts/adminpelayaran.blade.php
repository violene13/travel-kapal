<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

  <style>
    /* === GLOBAL === */
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: #F4F8FB;
      display: flex;
      min-height: 100vh;
    }

    /* === TOPBAR === */
    .topbar {
      backdrop-filter: blur(12px);
      background: linear-gradient(135deg, #018688, #5395b4);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      color: white;
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      z-index: 999;
      padding: 10px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
      transition: background 0.3s ease;
    }

    .topbar .brand {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .topbar .brand i {
      font-size: 1.4rem;
      color: #A7E6FF;
    }

    .topbar h5 {
      margin: 0;
      font-size: 1rem;
      font-weight: 600;
    }

    .topbar .right-info {
      display: flex;
      align-items: center;
      gap: 18px;
    }

    .datetime {
      font-size: 0.9rem;
      font-weight: 500;
      color: #f4fbff;
      background: rgba(255, 255, 255, 0.15);
      padding: 6px 14px;
      border-radius: 20px;
      box-shadow: inset 0 0 5px rgba(255,255,255,0.25);
    }

    .greeting {
      font-size: 0.9rem;
      color: #fff;
      opacity: 0.95;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .btn-logout {
      border: none;
      border-radius: 25px;
      font-size: 0.85rem;
      padding: 6px 16px;
      background: linear-gradient(135deg, #e7f3fe, #ffffff);
      color: #003B5C;
      font-weight: 600;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
      transition: all 0.3s ease;
    }

    .btn-logout:hover {
      background: linear-gradient(135deg, #A1C4FD, #C2E9FB);
      transform: translateY(-1px);
    }

    /* === SIDEBAR === */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background-color: #003B5C;
      color: white;
      display: flex;
      flex-direction: column;
      box-shadow: 2px 0 8px rgba(0,0,0,0.2);
      z-index: 1000;
    }

    .sidebar .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 20px 0;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      font-weight: bold;
      font-size: 16px;
      text-transform: uppercase;
      letter-spacing: 1px;
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
      transition: all 0.3s ease;
    }

    .sidebar nav a:hover {
      background-color: #025680;
      border-radius: 6px;
      transform: translateX(5px);
    }

    /* === MAIN CONTENT === */
    .content {
      margin-left: 250px;
      margin-top: 70px;
      padding: 30px 40px;
      width: calc(100% - 250px);
      background-color: #F4F8FB;
      min-height: 100vh;
    }

    .content-inner {
      background: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    @media (max-width: 992px) {
      .sidebar { width: 220px; }
      .topbar { left: 220px; }
      .content { margin-left: 220px; }
    }

    @media (max-width: 768px) {
      .sidebar { position: relative; width: 100%; height: auto; }
      .topbar { left: 0; flex-direction: column; align-items: flex-start; gap: 8px; }
      .content { margin-left: 0; margin-top: 90px; }
    }
  </style>
</head>

<body>
<aside class="sidebar">
  <div class="logo">
    <i class="bi bi-ship-fill"></i>
    <span>ADMIN SYSTEM</span>
  </div>

  <nav>
    <a href="{{ route('admin.pelayaran.dashboard') }}">
      <i class="bi bi-house"></i> Dashboard
    </a>

    <a href="{{ route('penumpang.penumpangpelayaran.index') }}">
      <i class="bi bi-person-vcard"></i> Data Akun Penumpang
    </a>

    <a href="{{ route('pemesanan.pemesananpelayaran.index') }}">
      <i class="bi bi-journal-text"></i> Pemesanan Pelayaran
    </a>

    <a href="{{ route('jalurpelayaran.index') }}">
      <i class="bi bi-signpost-split"></i> Jalur Pelayaran
    </a>

    <a href="{{ route('datakapal.index') }}">
      <i class="bi bi-water"></i> Data Kapal
    </a>

    <a href="{{ route('datapelabuhan.index') }}">
      <i class="bi bi-geo-alt"></i> Data Pelabuhan
    </a>

    <a href="{{ route('jadwalpelayaran.index') }}">
      <i class="bi bi-calendar-event"></i> Jadwal Pelayaran
    </a>

    <a href="{{ route('ticketing.index') }}">
      <i class="bi bi-cash-stack"></i> Ticketing
    </a>

    <a href="#">
      <i class="bi bi-graph-up"></i> Laporan
    </a>
  </nav>
</aside>

  <nav class="topbar">
    <div class="brand">
      <i class="bi bi-compass"></i>
      <h5>Sistem Informasi Pelayaran</h5>
    </div>
    <div class="right-info">
      <div class="datetime" id="datetime"></div>
      <div class="greeting"><i class="bi bi-person-circle"></i><h5> Halo, Admin</h5></div>
      <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="btn-logout">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
    </div>
  </nav>

  <main class="content">
    <div class="content-inner">
      @yield('content')
    </div>
  </main>

  <!-- === SCRIPT === -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script>
    function updateDateTime() {
      const now = new Date();
      const options = { 
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit', second: '2-digit'
      };
      document.getElementById('datetime').textContent = now.toLocaleDateString('id-ID', options);
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
  </script>

  @stack('scripts')
</body>
</html>
