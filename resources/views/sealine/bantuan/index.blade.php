@extends('layouts.pengguna')

@section('title', 'Bantuan - Sealine')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
/* --- STYLE UTAMA --- */
body {
  background: #f9fbfc;
}

/* Hero Section */
.hero-section {
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
  opacity: 0.9;
  font-size: 1.1rem;
  max-width: 700px;
  margin: 15px auto 0;
}

/* FAQ Section */
.faq-section {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.05);
  padding: 50px 30px;
  margin-top: -40px;
  z-index: 5;
  position: relative;
}
.faq-section h2 {
  color: #004080;
  font-weight: 700;
  margin-bottom: 20px;
}
.search-box {
  display: flex;
  align-items: center;
  border: 1px solid #ccc;
  border-radius: 50px;
  padding: 8px 16px;
  margin-bottom: 30px;
}
.search-box input {
  border: none;
  outline: none;
  flex: 1;
  font-size: 1rem;
  padding: 5px 10px;
}
.search-box i {
  color: #0077b6;
  font-size: 1.2rem;
}

/* Accordion FAQ */
.accordion-button {
  background: #f8fafc;
  border-radius: 10px !important;
  color: #004080;
  font-weight: 600;
  transition: all 0.3s ease;
}
.accordion-button:not(.collapsed) {
  background: #0077b6;
  color: white;
}
.accordion-body {
  background: #fefefe;
  color: #333;
  border-radius: 0 0 10px 10px;
}

/* Hubungi Kami */
.contact-section {
  margin-top: 60px;
  background: #f8fafc;
  border-radius: 16px;
  padding: 50px 30px;
}
.contact-section h3 {
  color: #004080;
  font-weight: 700;
  margin-bottom: 30px;
}
.contact-item {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}
.contact-item i {
  font-size: 2rem;
  color: #0077b6;
  margin-right: 15px;
}
.contact-item p {
  margin: 0;
  color: #555;
}
.contact-buttons button {
  margin-left: auto;
  border: none;
  border-radius: 20px;
  padding: 8px 18px;
  font-weight: 500;
  color: white;
  background: #00b4d8;
  transition: 0.3s;
}
.contact-buttons button:hover {
  background: #0077b6;
}

/* Tips Section */
.tips-section {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  padding: 50px 30px;
  margin-top: 60px;
}
.tips-section h3 {
  color: #004080;
  font-weight: 700;
  margin-bottom: 20px;
}
.tips-section ul {
  list-style: none;
  padding: 0;
}
.tips-section li {
  padding: 10px 0;
  font-size: 1rem;
  color: #333;
}
.tips-section li::before {
  content: "✔";
  color: #00b4d8;
  margin-right: 10px;
}

/* Quick Contact Form */
.quick-contact {
  background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
  color: white;
  padding: 60px 20px;
  border-radius: 16px;
  text-align: center;
  margin-top: 80px;
}
.quick-contact h3 {
  font-weight: 700;
  margin-bottom: 15px;
}
.quick-contact p {
  opacity: 0.9;
  margin-bottom: 25px;
}
.quick-contact form {
  max-width: 500px;
  margin: 0 auto;
}
.quick-contact input,
.quick-contact textarea {
  width: 100%;
  border: none;
  border-radius: 8px;
  padding: 10px 14px;
  margin-bottom: 15px;
}
.quick-contact button {
  background: white;
  color: #0077b6;
  font-weight: 600;
  border: none;
  border-radius: 25px;
  padding: 10px 20px;
  transition: 0.3s;
}
.quick-contact button:hover {
  background: #004080;
  color: white;
}
</style>

<div class="hero-section" data-aos="fade-down">
  <h1>Bantuan</h1>
  <p>Kami siap membantu menjawab pertanyaan dan kendala Anda seputar layanan Sealine.</p>
</div>

<div class="container faq-section" data-aos="fade-up">
  <h2>FAQ</h2>

  <div class="search-box mb-4">
    <input type="text" placeholder="Ketik pertanyaan anda ...">
    <i class="fa-solid fa-magnifying-glass"></i>
  </div>

  <div class="accordion" id="faqAccordion">
    <div class="accordion-item mb-3">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
          Bagaimana cara memesan tiket kapal?
        </button>
      </h2>
      <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Anda dapat memesan tiket kapal melalui menu "Pemesanan" di website Sealine, pilih rute dan jadwal keberangkatan, kemudian lakukan pembayaran secara online.
        </div>
      </div>
    </div>

    <div class="accordion-item mb-3">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
          Berapa harga tiket kapal?
        </button>
      </h2>
      <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Harga tiket bervariasi tergantung rute, kelas kapal, dan waktu keberangkatan. Semua harga akan ditampilkan secara transparan di halaman pemesanan.
        </div>
      </div>
    </div>

    <div class="accordion-item mb-3">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
          Bagaimana cara menghubungi Customer Service?
        </button>
      </h2>
      <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Anda dapat menghubungi tim kami melalui WhatsApp di +62 812 3456 7890 atau email ke cs@sealine.com. Kami siap membantu setiap hari.
        </div>
      </div>
    </div>

    <div class="accordion-item mb-3">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
          Bagaimana cara reschedule tiket kapal?
        </button>
      </h2>
      <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
          Reschedule dapat dilakukan maksimal 24 jam sebelum keberangkatan dengan menghubungi Customer Service dan menyertakan kode tiket Anda.
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container contact-section" data-aos="fade-up">
  <h3>Hubungi Kami</h3>

  <div class="contact-item d-flex">
    <i class="fa-brands fa-whatsapp"></i>
    <div>
      <strong>WhatsApp Kami</strong>
      <p>Kirim pertanyaanmu ke WhatsApp kami</p>
    </div>
    <div class="contact-buttons">
      <button>Hubungi</button>
    </div>
  </div>

  <div class="contact-item d-flex">
    <i class="fa-solid fa-envelope"></i>
    <div>
      <strong>Email Kami</strong>
      <p>Kirim pertanyaanmu ke cs@sealine.com</p>
    </div>
    <div class="contact-buttons">
      <button>Salin Email</button>
    </div>
  </div>
</div>

<div class="container tips-section" data-aos="fade-up">
  <h3>Tips Menggunakan Sealine</h3>
  <ul>
    <li>Pastikan koneksi internet stabil saat melakukan pemesanan.</li>
    <li>Gunakan metode pembayaran resmi yang tertera di website.</li>
    <li>Periksa kembali data penumpang sebelum menyelesaikan transaksi.</li>
    <li>Unduh tiket digital Anda untuk kemudahan check-in.</li>
  </ul>
</div>

<div class="quick-contact" data-aos="fade-up">
  <h3>Masih Butuh Bantuan?</h3>
  <p>Kirim pesan langsung ke tim kami melalui formulir di bawah ini.</p>
  <form>
    <input type="text" placeholder="Nama Anda">
    <input type="email" placeholder="Alamat Email">
    <textarea rows="3" placeholder="Tuliskan pertanyaan Anda..."></textarea>
    <button type="submit">Kirim Pesan</button>
  </form>
</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 1000, once: true });
</script>
@endsection
