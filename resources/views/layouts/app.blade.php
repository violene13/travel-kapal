<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #F4F8FB;
      display: flex;
      min-height: 100vh;
    }
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
    .sidebar nav a:hover,
    .sidebar nav a.active {
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
    .content {
      flex: 1;
      padding: 30px;
    }
    .card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-top: 20px;
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
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-house"></i> Dashboard
      </a>
      <a href="{{ route('penumpang.index') }}" class="{{ request()->routeIs('penumpang.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Data Penumpang
      </a>
      <a href="{{ route('pemesanan.index') }}" class="{{ request()->routeIs('pemesanan.*') ? 'active' : '' }}">
        <i class="bi bi-ticket-perforated"></i> Pemesanan
      </a>
      <a href="{{ route('perubahan_pembatalan.index') }}" class="{{ request()->routeIs('perubahan_pembatalan.*') ? 'active' : '' }}">
        <i class="bi bi-arrow-repeat"></i> Perubahan & Pembatalan
      </a>
      <a href="#"><i class="bi bi-graph-up"></i> Laporan</a>
    </nav>

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

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

  @stack('scripts')
  
</body>
</html>
