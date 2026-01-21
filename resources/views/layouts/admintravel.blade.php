<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin Travel')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #F4F8FB;
      display: flex;
      min-height: 100vh;
      overflow-x: visible; 
    }

    a { text-decoration: none; }

    /* === SIDEBAR === */
    .sidebar {
      width: 250px;
      background-color: #003B5C;
      color: white;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      bottom: 0;
      box-shadow: 2px 0 8px rgba(0,0,0,0.2);
      z-index: 1000;
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
      color: #A7E6FF;
    }

    .sidebar .logo span {
      font-weight: bold;
      font-size: 14px;
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
      color: #fff;
      transition: all 0.3s ease;
      border-left: 4px solid transparent;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
      background-color: #025680;
      border-left: 4px solid #A7E6FF;
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

    /* === MAIN CONTENT === */
    .content {
      flex: 1;
      padding: 100px 40px 40px 290px; 
      overflow-x: visible;
    }

    .card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      overflow-x: visible;
    }

    @media (max-width: 900px) {
      .topbar { left: 0; }
      .content { padding: 90px 20px; }
    }
  </style>
</head>

<body>
  <aside class="sidebar">
    <div class="logo">
      <i class="bi bi-ship"></i>
      <span>ADMIN TRAVEL</span>
    </div>

    <nav>
      <a href="{{ route('admin.travel.dashboard') }}" class="{{ request()->routeIs('admin.travel.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house"></i> Dashboard
      </a>
      <a href="{{ route('penumpang.penumpangtravel.index') }}" class="{{ request()->routeIs('penumpang.penumpangtravel.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Akun Penumpang
      </a>
      <a href="{{ route('pemesanan.pemesanantravel.index') }}" class="{{ request()->routeIs('pemesanan.pemesanantravel.*') ? 'active' : '' }}">
        <i class="bi bi-ticket-perforated"></i> Pemesanan
      </a>
      <a href="#"><i class="bi bi-graph-up"></i> Laporan</a>
    </nav>
  </aside>

  <nav class="topbar">
    <div class="brand">
      <i class="bi bi-compass"></i>
      <h5>Sistem Informasi Travel</h5>
    </div>
    <div class="right-info">
      <div class="datetime" id="datetime"></div>
      <div class="greeting">
        <i class="bi bi-person-circle"></i>
        <h5 style="margin:0;">Halo, Admin</h5>
      </div>
      <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="btn-logout">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
    </div>
  </nav>

  <main class="content">
    @yield('content')
  </main>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <script>
    // realtime
    setInterval(() => {
      const now = new Date();
      document.getElementById('datetime').textContent =
        now.toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' });
    }, 1000);
  </script>

  @stack('scripts')
  
</body>
</html>