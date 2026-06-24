```php
<?php
include "config/koneksi.php";

$produk = mysqli_query($koneksi,"
SELECT * FROM produk
ORDER BY id_produk DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Erlisna Florist</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<header>

    <div class="logo">
        <img src="assets/images/logo.png" alt="Logo">
        <h2>ERLISNA FLORIST</h2>
    </div>

    <nav>
        <a href="index.php">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="keranjang.php">Keranjang</a>
        <a href="tentang.php">Tentang Kami</a>
        <a href="pelanggan/login.php">Login</a>
    </nav>

</header>

<section class="hero">

<div class="hero-content">

<img src="assets/images/logo.png"
class="hero-logo">

<h1>Bunga Segar Untuk Orang Tersayang</h1>

<p>Pesan bunga dengan mudah dan cepat</p>

</div>

</section>

<section class="produk-section">

<div class="container">

<?php while($p=mysqli_fetch_array($produk)){ ?>

<div class="card">

    <?php if(!empty($p['gambar'])){ ?>
        <img src="assets/images/<?= $p['gambar']; ?>" alt="<?= $p['nama_bunga']; ?>">
    <?php }else{ ?>
        <img src="assets/images/logo.png" alt="Produk">
    <?php } ?>

    <div class="card-body">

        <h3><?= $p['nama_bunga']; ?></h3>

        <h4>
            Rp <?= number_format($p['harga'],0,",","."); ?>
        </h4>

        <a href="detail.php?id=<?= $p['id_produk']; ?>">
            Lihat Detail
        </a>

    </div>

</div>

<?php } ?>

</div>

</section>

</body>
</html>
```
