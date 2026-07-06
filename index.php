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

include "include/header.php";
?>

<section class="hero">
    <div class="container hero-grid">
        <div class="hero-content">
            <h1>Fresh Flowers For Every Moment</h1>
            <p>Rangkaian bunga segar untuk wisuda, ulang tahun, pernikahan, dan momen spesial lainnya.</p>
            <a href="produk.php" class="btn-primary">Belanja Sekarang</a>
        </div>
        <div class="hero-image">
            <img src="assets/images/banner.png" alt="Banner">
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

<section class="about">
<div class="container about-grid">
<div>
<img src="assets/images/toko.jpg" alt="Tentang Kami">
</div>
<div>
<h2>Tentang Erlisna Florist</h2>
<p>Kami menyediakan berbagai rangkaian bunga segar berkualitas untuk berbagai acara spesial.</p>
<ul>
<li>Bunga segar berkualitas</li>
<li>Harga terjangkau</li>
<li>Desain eksklusif</li>
<li>Pengiriman cepat</li>
</ul>
</div>
</div>
</section>

<section class="section">
<div class="container">
<div class="section-title">
<h2>Testimoni</h2>
</div>
<div class="testimonial-grid">
<div class="testimonial">
<img src="assets/images/user1.png">
<div class="stars">★★★★★</div>
<p>"Bunganya sangat cantik dan segar."</p>
<strong>Salsa</strong>
</div>
<div class="testimonial">
<img src="assets/images/user2.png">
<div class="stars">★★★★★</div>
<p>"Pelayanan cepat dan ramah."</p>
<strong>Rina</strong>
</div>
<div class="testimonial">
<img src="assets/images/user3.png">
<div class="stars">★★★★★</div>
<p>"Sangat puas dengan hasil bouquet."</p>
<strong>Dewi</strong>
</div>
</div>
</div>
</section>

<?php include "include/footer.php"; ?>
