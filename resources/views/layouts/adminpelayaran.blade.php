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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

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
      margin-left: 250px;
      flex: 1;
      padding: 30px;
    }

    .card {
      background: white;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    table th, table td {
      padding: 12px 15px;
      border-bottom: 1px solid #eee;
    }

    table th {
      background: #003B5C;
      color: white;
      text-align: left;
    }

    table tr:hover {
      background: #f5faff;
    }

    /* Button */
    .btn {
      padding: 6px 12px;
      font-size: 14px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      margin-right: 5px;
    }

    .btn-edit {
      background: #1d72b8;
      color: white;
    }

    .btn-edit:hover {
      background: #155d8b;
    }

    .btn-delete {
      background: #d9534f;
      color: white;
      border: none;
      cursor: pointer;
    }

    .btn-delete:hover {
      background: #b52b27;
    }

    .btn-add {
      background: #28a745;
      color: white;
    }

    .btn-add:hover {
      background: #1e7e34;
    }

    /* DataTables Custom */
    .dataTables_filter {
      float: left !important;
      text-align: left !important;
      margin-left: 10px;
    }

    .dataTables_length {
      float: right !important;
      margin-right: 10px;
    }

    table.dataTable th,
    table.dataTable td {
      white-space: nowrap;
      padding: 6px 10px;
      font-size: 14px;
    }

    #dataKapalTable thead th {
      text-align: center !important;
      vertical-align: middle;
    }

    /* ✅ Tambahan penting */
    .form-container {
      max-width: 600px;
      margin-left: 40px; /* biar gak nempel sidebar */
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        float: left !important;
        text-align: left !important;
    }

    .dataTables_wrapper .dataTables_filter label {
        width: 100%;
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 0 !important;
        display: block;
        width: 200px; /* biar tetap rapi */
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
      <a href="{{ route('admin.pelayaran.dashboard') }}"><i class="bi bi-house"></i> Dashboard</a>
      <a href="{{ route('jalurpelayaran.index') }}"><i class="bi bi-people"></i> Jalur Pelayaran</a>
      <a href="{{ route('datakapal.index') }}"><i class="bi bi-ticket-perforated"></i> Data Kapal</a>
      <a href="{{ route('datapelabuhan.index') }}"><i class="bi bi-arrow-repeat"></i> Data Pelabuhan</a>
      <a href="{{ route('jadwalpelayaran.index') }}"><i class="bi bi-calendar-event"></i> Jadwal Pelayaran</a>
      <a href="#"><i class="bi bi-graph-up"></i> Laporan</a>
    </nav>

    <!-- Logout -->
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  
  @stack('scripts')
</body>
</html>
