<?php
session_start();

include "config/koneksi.php";


// =============================
// SEARCH PRODUK
// =============================

$cari = "";

if(isset($_GET['cari'])){

    $cari = mysqli_real_escape_string(
        $koneksi,
        $_GET['cari']
    );

}


$where = "";

if($cari!=""){

    $where="
    WHERE nama_bunga LIKE '%$cari%'
    ";

}



// =============================
// PRODUK TERBARU
// =============================

$produk = mysqli_query($koneksi,"
SELECT *
FROM produk
$where
ORDER BY id_produk DESC
LIMIT 8
");



include "includes/header.php";

?>



<!-- =========================
 HERO
========================= -->


<section class="hero">


<div class="container hero-grid">


<div class="hero-content">


<h1>
Fresh Flowers
For Every Moment
</h1>


<p>
Rangkaian bunga segar untuk wisuda,
ulang tahun, pernikahan,
dan momen spesial lainnya.
</p>



<a href="produk.php"
class="btn-primary">

Belanja Sekarang

</a>


</div>



<div class="hero-image">


<img src="assets/images/bg web.jpg"
alt="Erlisna Florist">


</div>


</div>


</section>





<!-- =========================
 PRODUK TERBARU
========================= -->


<section class="section">


<div class="container">


<div class="section-title">


<h2>
🌸 Produk Terbaru
</h2>


<p>
Koleksi bunga pilihan Erlisna Florist
</p>


</div>




<div class="product-grid">



<?php while($p=mysqli_fetch_assoc($produk)){ ?>


<div class="card">


<img 
src="assets/images/<?= 
!empty($p['gambar'])
?
$p['gambar']
:
'logo.png';
?>">



<div class="card-body">


<span class="badge">
Ready
</span>



<h3>

<?= htmlspecialchars(
$p['nama_bunga']
);

?>

</h3>



<p class="price">

Rp 
<?= number_format(
$p['harga'],
0,
",",
"."
);

?>

</p>




<a href="detail_produk.php?id=
<?= $p['id_produk']; ?>"
class="btn-primary">

Lihat Detail

</a>



</div>


</div>



<?php } ?>



</div>


</div>


</section>

<!-- =========================
 KATEGORI
========================= -->


<section class="section">


<div class="container">


<div class="section-title">

<h2>
🌷 Kategori Bunga
</h2>

<p>
Pilih sesuai kebutuhan Anda
</p>

</div>




<div class="product-grid">



<div class="card">

<img src="assets/images/buket1.jpg">


<div class="card-body">

<h3>
Buket Bunga Asli
</h3>


<a href="produk.php?kategori=1"
class="btn-primary">

Lihat Produk

</a>

</div>


</div>





<div class="card">

<img src="assets/images/buket w2.jpg">


<div class="card-body">


<h3>
Buket Wisuda
</h3>


<a href="produk.php?kategori=2"
class="btn-primary">

Lihat Produk

</a>


</div>


</div>





<div class="card">


<img src="assets/images/buket a3.jpg">


<div class="card-body">


<h3>
Buket Ulang Tahun
</h3>


<a href="produk.php?kategori=3"
class="btn-primary">

Lihat Produk

</a>


</div>


</div>





<div class="card">


<img src="assets/images/buket r1.jpg">


<div class="card-body">


<h3>
Buket Rajut
</h3>


<a href="produk.php?kategori=4"
class="btn-primary">

Lihat Produk

</a>


</div>


</div>




</div>


</div>


</section>





<?php


// =============================
// PRODUK TERLARIS
// =============================


$laris=mysqli_query($koneksi,"
SELECT *
FROM produk
ORDER BY id_produk DESC
LIMIT 4

");


?>



<section class="section">


<div class="container">


<div class="section-title">

<h2>
⭐ Produk Favorit
</h2>

<p>
Pilihan pelanggan Erlisna Florist
</p>

</div>



<div class="product-grid">



<?php while($p=mysqli_fetch_assoc($laris)){ ?>



<div class="card">


<img src="assets/images/<?= $p['gambar']; ?>">



<div class="card-body">


<h3>

<?= $p['nama_bunga']; ?>

</h3>



<p class="price">

Rp <?= number_format(
$p['harga'],
0,
",",
"."
);

?>

</p>



<a href="detail_produk.php?id=
<?= $p['id_produk']; ?>"
class="btn-primary">

Pesan Sekarang

</a>


</div>


</div>



<?php } ?>



</div>



</div>


</section>

<?php

// =============================
// PRODUK PROMO
// =============================

$promo=mysqli_query($koneksi,"
SELECT *
FROM produk
ORDER BY RAND()
LIMIT 4
");

?>


<section class="section promo-section">


<div class="container">


<div class="section-title">


<h2>
🎁 Promo Minggu Ini
</h2>


<p>
Harga spesial untuk pelanggan
Erlisna Florist
</p>


</div>



<div class="product-grid">



<?php while($p=mysqli_fetch_assoc($promo)){ ?>


<div class="card promo-card">



<div class="discount">

-20%

</div>



<img src="assets/images/<?= $p['gambar']; ?>">



<div class="card-body">



<h3>

<?= $p['nama_bunga']; ?>

</h3>



<p class="old-price">

Rp 
<?= number_format(
$p['harga']+50000,
0,
",",
"."
);

?>

</p>



<p class="price">

Rp 
<?= number_format(
$p['harga'],
0,
",",
"."
);

?>

</p>




<a href="detail_produk.php?id=
<?= $p['id_produk']; ?>"
class="btn-primary">

Beli Sekarang

</a>



</div>



</div>



<?php } ?>



</div>


</div>


</section>





<!-- =========================
 TESTIMONI
========================= -->


<section class="section testimonial-section">


<div class="container">


<div class="section-title">


<h2>
❤️ Testimoni Pelanggan
</h2>


<p>
Pengalaman pelanggan Erlisna Florist
</p>


</div>




<div class="product-grid">



<div class="testimonial">


<img src="assets/images/salsa.jpeg">


<h3>
Salsa Putri
</h3>



<div class="stars">

★★★★★

</div>



<p>

"Buket sangat cantik,
bunganya segar dan
pengiriman cepat."

</p>



</div>





<div class="testimonial">


<img src="assets/images/PTS.jpg">


<h3>
Nabila
</h3>



<div class="stars">

★★★★★

</div>



<p>

"Pelayanan ramah,
hasil bouquet sangat bagus."

</p>



</div>






<div class="testimonial">


<img src="assets/images/user3.jpg">


<h3>
Dewi Ayu
</h3>



<div class="stars">

★★★★★

</div>



<p>

"Harga terjangkau
dan bunga berkualitas."

</p>



</div>



</div>


</div>


</section>





<!-- =========================
 GALERI
========================= -->


<section class="section">


<div class="container">


<div class="section-title">


<h2>
📸 Galeri Bunga
</h2>


<p>
Inspirasi bouquet Erlisna Florist
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

<!-- =========================
 TENTANG KAMI
========================= -->


<section class="about">


<div class="container about-grid">



<div>


<h2>
Mengapa Memilih
Erlisna Florist?
</h2>



<ul>

<li>
🌸 Bunga segar berkualitas premium
</li>


<li>
🌸 Desain bouquet modern
</li>


<li>
🌸 Harga terjangkau
</li>


<li>
🌸 Pengiriman cepat
</li>


<li>
🌸 Bisa custom bouquet
</li>


</ul>



</div>




<div>


<img src="assets/images/logo.png">


</div>



</div>


</section>






<!-- =========================
 KONTAK
========================= -->


<section class="contact-section">


<div class="container">



<div class="section-title">


<h2>
Hubungi Kami
</h2>


<p>
Kami siap membantu pesanan Anda
</p>


</div>




<div class="product-grid">



<div class="contact-box">


<h3>
📍 Alamat
</h3>


<p>
Jl. Raya Denpasar No.123
<br>
Denpasar, Bali
</p>


</div>




<div class="contact-box">


<h3>
📱 WhatsApp
</h3>


<p>
0812-3456-7890
</p>


</div>




<div class="contact-box">


<h3>
✉ Email
</h3>


<p>
erlisnaflorist@gmail.com
</p>


</div>



</div>



</div>


</section>






<!-- =========================
 MAP
========================= -->


<section class="maps">


<iframe

src="https://www.google.com/maps/embed?pb=!1m18"

loading="lazy">

</iframe>


</section>







<!-- =========================
 CTA
========================= -->


<section class="cta">


<div class="container">


<h2>
Buat Momen Spesial Lebih Indah
</h2>


<p>

Pesan bouquet favoritmu
sekarang bersama Erlisna Florist

</p>



<a href="produk.php"
class="btn-primary">

Belanja Sekarang

</a>


</div>


</section>






<!-- =========================
 NEWSLETTER
========================= -->


<section class="newsletter">


<div class="container">


<h2>

Dapatkan Promo Terbaru

</h2>



<p>

Masukkan email untuk mendapatkan
informasi terbaru

</p>




<form method="post">


<input 
type="email"
name="email"
placeholder="Masukkan Email Anda"
required>


<button type="submit">

Subscribe

</button>



</form>



</div>


</section>





<?php

include "includes/footer.php";

?>