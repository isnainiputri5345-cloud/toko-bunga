<?php
session_start();
include "config/koneksi.php";

$cari = $_GET['cari'] ?? '';
$where = "";
if($cari!=""){
    $c = mysqli_real_escape_string($koneksi,$cari);
    $where = "WHERE nama_bunga LIKE '%$c%'";
}

$produk = mysqli_query($koneksi,"
SELECT * FROM produk
$where
ORDER BY id_produk DESC
LIMIT 8
");

include "includes/header.php";
?>

<section class="hero">
    <div class="container hero-grid">
        <div class="hero-content">
            <h1>Fresh Flowers For Every Moment</h1>
            <p>Rangkaian bunga segar untuk wisuda, ulang tahun, pernikahan, dan momen spesial lainnya.</p>
            <a href="produk.php" class="btn-primary">Belanja Sekarang</a>
        </div>
        <div class="hero-image">
            <img src="assets/images/bg web.jpg" alt="Banner">
        </div>
    </div>
</section>

<section class="section">
<div class="container">
<div class="section-title">
<h2>Produk Terbaru</h2>
<p>Koleksi bunga pilihan Erlisna Florist</p>
</div>

<div class="product-grid">
<?php while($p=mysqli_fetch_assoc($produk)){ ?>
<div class="card">
<img src="assets/images/<?= !empty($p['gambar'])?$p['gambar']:'logo.png'; ?>" alt="">
<div class="card-body">
<span class="badge">Ready</span>
<h3><?= htmlspecialchars($p['nama_bunga']); ?></h3>
<div class="price">Rp <?= number_format($p['harga'],0,",","."); ?></div>
<a class="btn-primary" href="detail.php?id=<?= $p['id_produk']; ?>">Lihat Detail</a>
</div>
</div>
<?php } ?>
</div>
</div>
</section>

<!-- INDEX PART 2 -->


<section class="section">
<div class="container">
<div class="section-title"><h2>Kategori Produk</h2></div>
<div class="product-grid">
<a class="card" href="produk.php?kategori=1"><img src="assets/images/buket1.jpg"><div class="card-body"><h3>Bouquet</h3></div></a>
<a class="card" href="produk.php?kategori=2"><img src="assets/images/buket w2.jpg"><div class="card-body"><h3>Wisuda</h3></div></a>
<a class="card" href="produk.php?kategori=3"><img src="assets/images/buket a3.jpg"><div class="card-body"><h3>Pernikahan</h3></div></a>
<a class="card" href="produk.php?kategori=4"><img src="assets/images/buket r1.jpg"><div class="card-body"><h3>Standing Flower</h3></div></a>
</div></div></section>

<?php
/* ==========================================
   PRODUK TERLARIS
========================================== */

$produk_terlaris = mysqli_query($koneksi,"
SELECT *
FROM produk
ORDER BY id_produk DESC
LIMIT 4
");
?>

<section class="section best-seller">

<div class="container">

<div class="section-title">

<h2>🌸 Produk Terlaris</h2>

<p>
Rangkaian bunga favorit pelanggan
Erlisna Florist.
</p>

</div>

<div class="product-grid">

<?php while($p=mysqli_fetch_assoc($produk_terlaris)){ ?>

<div class="card">

<div class="badge">

⭐ Terlaris

</div>

<img
src="assets/images/<?= $p['gambar']; ?>"
alt="<?= $p['nama_bunga']; ?>">

<div class="card-body">

<h3>

<?= $p['nama_bunga']; ?>

</h3>

<p class="price">

Rp <?= number_format($p['harga'],0,",","."); ?>

</p>

<p>

<?= substr($p['deskripsi'],0,70); ?>...

</p>

<br>

<a
href="detail.php?id=<?= $p['id_produk']; ?>"
class="btn-primary">

Lihat Detail

</a>

</div>

</div>

<?php } ?>

</div>

</div>

</section>

<?php
/*==================================
PRODUK PROMO
===================================*/

$promo = mysqli_query($koneksi,"
SELECT *
FROM produk
ORDER BY RAND()
LIMIT 4
");
?>

<section class="section promo-section">

<div class="container">

<div class="section-title">

<h2>🎁 Promo Minggu Ini</h2>

<p>
Nikmati berbagai penawaran menarik
khusus pelanggan Erlisna Florist.
</p>

</div>

<div class="promo-grid">

<?php while($p=mysqli_fetch_assoc($promo)){ ?>

<div class="promo-card">

<span class="discount">

-20%

</span>

<img
src="assets/images/<?= $p['gambar']; ?>"
alt="<?= $p['nama_bunga']; ?>">

<div class="card-body">

<h3>

<?= $p['nama_bunga']; ?>

</h3>

<p class="old-price">

Rp
<?= number_format($p['harga']+50000,0,",","."); ?>

</p>

<p class="new-price">

Rp
<?= number_format($p['harga'],0,",","."); ?>

</p>

<a
href="detail.php?id=<?= $p['id_produk']; ?>"
class="btn-primary">

Belanja Sekarang

</a>

</div>

</div>

<?php } ?>

</div>

</div>

</section>

<section class="section testimonial-section">

<div class="container">

<div class="section-title">

<h2>

❤️ Apa Kata Pelanggan

</h2>

<p>

Testimoni pelanggan
Erlisna Florist

</p>

</div>

<div class="testimonial-grid">

<div class="testimonial">

<img
src="assets/images/salsa.jpeg">

<div class="stars">

★★★★★

</div>

<h3>

Salsa Putri

</h3>

<p>

Bouquet sangat cantik,
bunganya segar dan
pengirimannya cepat.

</p>

</div>

<div class="testimonial">

<img
src="assets/images/PTS.jpg">

<div class="stars">

★★★★★

</div>

<h3>

Nabila

</h3>

<p>

Pelayanan ramah,
hasil bouquet lebih
bagus dari ekspektasi.

</p>

</div>

<div class="testimonial">

<img
src="assets/images/user3.jpg">

<div class="stars">

★★★★★

</div>

<h3>

Dewi Ayu

</h3>

<p>

Harga terjangkau
dan kualitas bunga
sangat memuaskan.

</p>

</div>

</div>

</div>

</section>

<section class="section">

<div class="container">

<div class="section-title">

<h2>

📸 Galeri Bunga

</h2>

<p>

Inspirasi rangkaian bunga
Erlisna Florist

</p>

</div>

<div class="product-grid">

<div class="card">

<img src="assets/images/buket a4.jpg">

</div>

<div class="card">

<img src="assets/images/buket r1.jpg">

</div>

<div class="card">

<img src="assets/images/buket w2.jpg">

</div>

<div class="card">

<img src="assets/images/buket3.jpg">

</div>

</div>

</div>

</section>

<section class="about">
<div class="container about-grid">
<div>
<h2>Mengapa Memilih Erlisna Florist?</h2>
<ul>
<li>Bunga segar berkualitas premium.</li>
<li>Desain bouquet modern.</li>
<li>Harga bersahabat.</li>
<li>Pengiriman cepat.</li>
<li>Melayani custom bouquet.</li>
</ul>
</div>
<div><img src="assets/images/logo.png"></div>
</div></section>

<?php include "includes/footer.php"; ?>
