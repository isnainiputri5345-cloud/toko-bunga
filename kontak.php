<?php
session_start();
include "config/koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kontak Kami | Erlisna Florist</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<?php include "includes/header.php"; ?>


<!-- ==========================================
                HERO
========================================== -->

<section class="contact-hero">

<div class="container contact-hero-grid">

<!-- ================= KIRI ================= -->

<div class="contact-hero-content">

<span class="contact-tag">

🌸 Hubungi Kami

</span>

<h1>

Kami Siap Membantu
Mewujudkan Momen
Spesial Anda

</h1>

<p>

Apabila Anda memiliki pertanyaan mengenai produk,
proses pemesanan, pengiriman, ataupun ingin membuat
bouquet custom, silakan hubungi kami melalui kontak
yang tersedia. Tim Erlisna Florist siap melayani Anda
dengan ramah dan cepat.

</p>

<div class="hero-button">

<a href="produk.php" class="btn-primary">

<i class="fa-solid fa-gift"></i>

Lihat Produk

</a>

<a
href="https://wa.me/6281234567890"
target="_blank"
class="btn-wa">

<i class="fab fa-whatsapp"></i>

WhatsApp

</a>

</div>

</div>

<!-- ================= KANAN ================= -->

<div class="contact-hero-image">

<img
src="assets/images/logo.png"
alt="Erlisna Florist">

</div>

</div>

</section>



<!-- ==========================================
            INFORMASI KONTAK
========================================== -->

<section class="contact-info-section">

<div class="container">

<div class="section-title">

<span class="subtitle">

🌸 Erlisna Florist

</span>

<h2>

Informasi Kontak

</h2>

<p>

Silakan hubungi kami melalui salah satu media berikut.
Kami siap membantu Anda setiap hari.

</p>

</div>


<div class="contact-info-grid">

<!-- ================= ALAMAT ================= -->

<div class="contact-card">

<div class="contact-icon">

<i class="fa-solid fa-location-dot"></i>

</div>

<h3>Alamat</h3>

<p>

Jl. Contoh No.123<br>

Kota Bengkulu<br>

Indonesia

</p>

<a
href="https://maps.google.com"
target="_blank"
class="mini-btn">

Lihat Lokasi

</a>

</div>


<!-- ================= WHATSAPP ================= -->

<div class="contact-card">

<div class="contact-icon">

<i class="fab fa-whatsapp"></i>

</div>

<h3>WhatsApp</h3>

<p>

0812-3456-7890

</p>

<a
href="https://wa.me/6281234567890"
target="_blank"
class="mini-btn">

Chat Sekarang

</a>

</div>


<!-- ================= EMAIL ================= -->

<div class="contact-card">

<div class="contact-icon">

<i class="fa-solid fa-envelope"></i>

</div>

<h3>Email</h3>

<p>

erlisnaflorist@gmail.com

</p>

<a
href="mailto:erlisnaflorist@gmail.com"
class="mini-btn">

Kirim Email

</a>

</div>


<!-- ================= JAM ================= -->

<div class="contact-card">

<div class="contact-icon">

<i class="fa-solid fa-clock"></i>

</div>

<h3>Jam Operasional</h3>

<p>

Senin - Minggu

<br>

08.00 - 21.00 WIB

</p>

<a
href="produk.php"
class="mini-btn">

Lihat Produk

</a>

</div>

</div>

</div>

</section>


<!-- ==========================================
BATAS PART 1

Selanjutnya:
kontak_part2.php
(Form Kontak + Google Maps)
========================================== -->
<!-- ==========================================
        FORM KONTAK & LOKASI TOKO
========================================== -->

<section class="contact-form-section">

<div class="container">

<div class="contact-wrapper">

<!-- ================= FORM ================= -->

<div class="contact-form-box">

<div class="section-title">

<span class="subtitle">

🌸 Hubungi Kami

</span>

<h2>

Kirim Pesan

</h2>

<p>

Silakan isi formulir di bawah ini apabila Anda memiliki
pertanyaan, kritik, saran, ataupun ingin melakukan
pemesanan bouquet custom.

</p>

</div>

<form action="" method="POST">

<div class="input-group">

<label>

<i class="fa-solid fa-user"></i>

Nama Lengkap

</label>

<input
type="text"
name="nama"
placeholder="Masukkan nama lengkap Anda"
required>

</div>

<div class="input-group">

<label>

<i class="fa-solid fa-envelope"></i>

Email

</label>

<input
type="email"
name="email"
placeholder="Masukkan email aktif"
required>

</div>

<div class="input-group">

<label>

<i class="fa-brands fa-whatsapp"></i>

Nomor WhatsApp

</label>

<input
type="text"
name="telepon"
placeholder="08xxxxxxxxxx"
required>

</div>

<div class="input-group">

<label>

<i class="fa-solid fa-tag"></i>

Subjek

</label>

<input
type="text"
name="subjek"
placeholder="Contoh : Pemesanan Bouquet Wisuda">

</div>

<div class="input-group">

<label>

<i class="fa-solid fa-comment-dots"></i>

Pesan

</label>

<textarea

name="pesan"

rows="6"

placeholder="Tuliskan pesan Anda..."

required>

</textarea>

</div>

<button
type="submit"
class="btn-primary">

<i class="fa-solid fa-paper-plane"></i>

Kirim Pesan

</button>

</form>

</div>

<!-- ================= MAP ================= -->

<div class="contact-map">

<div class="section-title">

<span class="subtitle">

📍 Lokasi Kami

</span>

<h2>

Kunjungi Toko Kami

</h2>

<p>

Datang langsung ke toko Erlisna Florist untuk melihat
koleksi bouquet terbaik, berkonsultasi, atau melakukan
pemesanan secara langsung.

</p>

</div>

<div class="map-box">

<iframe

src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63820.605165!2d102.248!3d-3.792!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e36b03d4c7d0001%3A0x123456789!2sBengkulu!5e0!3m2!1sid!2sid!4v1710000000000"

loading="lazy"

allowfullscreen=""

referrerpolicy="no-referrer-when-downgrade">

</iframe>

</div>

<div class="location-detail">

<div class="location-item">

<i class="fa-solid fa-location-dot"></i>

<div>

<h4>Alamat</h4>

<p>

Jl. Contoh No.123,
Kota Bengkulu,
Indonesia

</p>

</div>

</div>

<div class="location-item">

<i class="fa-solid fa-phone"></i>

<div>

<h4>Telepon</h4>

<p>

0812-3456-7890

</p>

</div>

</div>

<div class="location-item">

<i class="fa-solid fa-envelope"></i>

<div>

<h4>Email</h4>

<p>

erlisnaflorist@gmail.com

</p>

</div>

</div>

<div class="location-item">

<i class="fa-solid fa-clock"></i>

<div>

<h4>Jam Operasional</h4>

<p>

Senin - Minggu<br>

08.00 - 21.00 WIB

</p>

</div>

</div>

<div class="map-button">

<a
href="https://maps.google.com"
target="_blank"
class="btn-primary">

<i class="fa-solid fa-location-arrow"></i>

Buka Google Maps

</a>

</div>

</div>

</div>

</div>

</div>

</section>

<!-- ==========================================
BATAS PART 2

Selanjutnya :
kontak_part3.php

- FAQ Modern
- Call To Action
- Ikuti Kami
- Bantuan WhatsApp
- Footer
========================================== -->
<!-- ==========================================
                FAQ
========================================== -->

<section class="faq-section">

<div class="container">

<div class="section-title">

<span class="subtitle">

❓ FAQ

</span>

<h2>

Pertanyaan yang Sering Diajukan

</h2>

<p>

Berikut beberapa pertanyaan yang paling sering ditanyakan pelanggan
Erlisna Florist.

</p>

</div>

<div class="faq-grid">

<div class="faq-card">

<div class="faq-icon">

<i class="fa-solid fa-seedling"></i>

</div>

<h3>Apakah Bisa Custom Bouquet?</h3>

<p>

Ya. Anda dapat menentukan jenis bunga, warna, ukuran,
hingga budget sesuai keinginan.

</p>

</div>

<div class="faq-card">

<div class="faq-icon">

<i class="fa-solid fa-truck-fast"></i>

</div>

<h3>Apakah Melayani Pengiriman?</h3>

<p>

Kami melayani pengiriman dalam kota maupun luar kota
sesuai ketentuan yang berlaku.

</p>

</div>

<div class="faq-card">

<div class="faq-icon">

<i class="fa-solid fa-credit-card"></i>

</div>

<h3>Metode Pembayaran</h3>

<p>

Transfer Bank, QRIS,
dan pembayaran langsung di toko.

</p>

</div>

<div class="faq-card">

<div class="faq-icon">

<i class="fa-solid fa-clock"></i>

</div>

<h3>Berapa Lama Proses Pengerjaan?</h3>

<p>

Pemesanan normal sekitar 1-3 jam,
sedangkan custom bouquet menyesuaikan desain.

</p>

</div>

</div>

</div>

</section>


<!-- ==========================================
            CALL TO ACTION
========================================== -->

<section class="contact-cta">

<div class="container">

<div class="cta-box">

<h2>

🌸 Siap Memberikan Kejutan Terindah?

</h2>

<p>

Temukan berbagai bouquet bunga terbaik untuk wisuda,
ulang tahun, anniversary, pernikahan,
dan berbagai momen spesial lainnya.

</p>

<div class="cta-button">

<a href="produk.php" class="btn-primary">

<i class="fa-solid fa-cart-shopping"></i>

Belanja Sekarang

</a>

<a
href="https://wa.me/6281234567890"
target="_blank"
class="btn-wa">

<i class="fab fa-whatsapp"></i>

Chat WhatsApp

</a>

</div>

</div>

</div>

</section>


<!-- ==========================================
            MEDIA SOSIAL
========================================== -->

<section class="social-section">

<div class="container">

<div class="section-title">

<span class="subtitle">

📱 Media Sosial

</span>

<h2>

Ikuti Kami

</h2>

<p>

Ikuti media sosial Erlisna Florist
untuk mendapatkan promo terbaru,
koleksi bouquet terbaru,
dan berbagai inspirasi hadiah spesial.

</p>

</div>

<div class="social-grid">

<a
href="https://instagram.com/"
target="_blank"
class="social-card instagram">

<i class="fab fa-instagram"></i>

<h3>Instagram</h3>

<p>@erlisnaflorist</p>

</a>

<a
href="https://facebook.com/"
target="_blank"
class="social-card facebook">

<i class="fab fa-facebook-f"></i>

<h3>Facebook</h3>

<p>Erlisna Florist</p>

</a>

<a
href="https://wa.me/6281234567890"
target="_blank"
class="social-card whatsapp">

<i class="fab fa-whatsapp"></i>

<h3>WhatsApp</h3>

<p>0812-3456-7890</p>

</a>

<a
href="https://tiktok.com/"
target="_blank"
class="social-card tiktok">

<i class="fab fa-tiktok"></i>

<h3>TikTok</h3>

<p>@erlisnaflorist</p>

</a>

</div>

</div>

</section>


<!-- ==========================================
        BUTUH BANTUAN
========================================== -->

<section class="newsletter">

<div class="container">

<div class="newsletter-box">

<i class="fa-solid fa-headset newsletter-icon"></i>

<h2>

Masih Ada Pertanyaan?

</h2>

<p>

Admin Erlisna Florist siap membantu Anda setiap hari.
Silakan hubungi kami melalui WhatsApp untuk konsultasi,
pemesanan bouquet custom,
atau informasi produk lainnya.

</p>

<a
href="https://wa.me/6281234567890"
target="_blank"
class="btn-wa">

<i class="fab fa-whatsapp"></i>

Hubungi Admin

</a>

</div>

</div>

</section>


<!-- ==========================================
            FOOTER
========================================== -->

<?php include "includes/footer.php"; ?>


<!-- ==========================================
        FLOATING WHATSAPP
========================================== -->

<a
href="https://wa.me/6281234567890"
target="_blank"
class="whatsapp-float">

<i class="fab fa-whatsapp"></i>

</a>

</body>

</html>