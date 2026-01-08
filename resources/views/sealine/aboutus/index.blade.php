  @extends('layouts.pengguna')

  @section('title', 'Tentang Kami - Sealine')

  @section('content')
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
  .hero-section {
      margin-top: 0 !important;
    background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
    color: white;
    text-align: center;
    padding: 100px 20px 80px;
  }
  .hero-section h1 {
    font-weight: 700;
    font-size: 2.8rem;
  }
  .hero-section p {
    font-size: 1.1rem;
    opacity: 0.9;
    max-width: 700px;
    margin: 15px auto 0;
  }

  .about-section {
    background: #fff;
    padding: 70px 15px; 
  }
  .about-section .row {
    align-items: center;
    margin-bottom: 60px;
  }
  .about-section img {
    width: 100%;
    border-radius: 16px;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
  }
  .about-section img:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  }
  .about-section h2 {
    font-weight: 700;
    color: #004080;
    margin-bottom: 15px;
  }
  .about-section p {
    color: #333;
    line-height: 1.7;
    font-size: 1rem;
  }

  .highlight {
    background: linear-gradient(90deg, #0077b6, #00b4d8);
    color: white;
    border-radius: 16px;
    padding: 60px 30px;
    text-align: center;
    margin-top: 30px;
  }
  .highlight h3 {
    font-weight: 700;
    margin-bottom: 15px;
  }
  .highlight p {
    font-size: 1.05rem;
    opacity: 0.9;
  }

  .values {
    background: #f8fafc;
    padding: 80px 20px; 
    text-align: center;
  }
  .values h2 {
    font-weight: 700;
    color: #004080;
    margin-bottom: 40px;
  }
  .values .card {
    border: none;
    border-radius: 16px;
    background: white;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
  }
  .values .card:hover {
    transform: translateY(-8px);
  }
  .values .icon {
    font-size: 40px;
    color: #0077b6;
    margin-bottom: 15px;
  }

  .team {
    background: #fff;
    padding: 80px 0;
    text-align: center;
  }
  .team h2 {
    font-weight: 700;
    color: #004080;
    margin-bottom: 40px;
  }
  .team .card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
  }
  .team .card:hover {
    transform: translateY(-8px);
  }
  .team img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
  }
  .team .card-body {
    padding: 15px;
  }
  .team .card-body h5 {
    font-weight: 600;
    color: #004080;
  }
  .team .card-body p {
    font-size: 0.9rem;
    color: #666;
  }
  </style>

  <div class="hero-section" data-aos="fade-down">
    <h1>Tentang Sealine</h1>
    <p>Platform pemesanan tiket kapal penumpang</p>
    <p> aman, cepat, dan praktis tanpa perlu antre di loket.</p>
  </div>

  <section class="about-section container">
    <div class="row" data-aos="fade-right">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="{{ asset('images/orang.jpeg') }}" alt="Penumpang di Pelabuhan">
      </div>
      <div class="col-md-6">
        <h2>Apa itu Sealine?</h2>
        <p>
          Sealine adalah platform untuk membeli tiket kapal penumpang secara mudah, nyaman, dan praktis.
          Didirikan pada tahun <b>2025</b>, Sealine hadir untuk membantu pengguna memesan tiket tanpa harus datang langsung ke loket.
        </p>
      </div>
    </div>

    <div class="row flex-md-row-reverse" data-aos="fade-left">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="{{ asset('images/orang1.jpeg') }}" alt="Penumpang naik kapal">
      </div>
      <div class="col-md-6">
        <h2>Bagaimana Sealine Membantu Anda?</h2>
        <p>
          Melalui platform ini, pengguna dapat melihat jadwal keberangkatan, memilih rute, dan melakukan pembayaran dengan aman.
          Sealine dirancang agar proses pemesanan menjadi <b>sederhana</b>, <b>aman</b>, dan <b>nyaman</b> untuk semua orang.
        </p>
      </div>
    </div>

    <div class="highlight" data-aos="zoom-in">
      <h3>Visi Kami</h3>
      <p>
        Menjadi solusi digital terbaik untuk transportasi laut di Indonesia dengan memberikan pengalaman pemesanan tiket kapal yang efisien, ramah pengguna, dan terpercaya.
      </p>
    </div>
  </section>

  <section class="values" data-aos="fade-up">
    <div class="container">
      <h2>Nilai & Komitmen Kami</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card p-4">
            <div class="icon"><i class="fas fa-ship"></i></div>
            <h5>Kemudahan Akses</h5>
            <p>Membawa layanan pemesanan tiket kapal langsung ke genggaman Anda.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-4">
            <div class="icon"><i class="fas fa-lock"></i></div>
            <h5>Keamanan Data</h5>
            <p>Kami menjamin setiap transaksi dan informasi pengguna terlindungi dengan baik.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card p-4">
            <div class="icon"><i class="fas fa-heart"></i></div>
            <h5>Kenyamanan Pengguna</h5>
            <p>Memberikan pengalaman yang cepat, intuitif, dan menyenangkan bagi setiap pelanggan.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
  AOS.init({
    duration: 1000,
    once: true
  });
  </script>
  @endsection
