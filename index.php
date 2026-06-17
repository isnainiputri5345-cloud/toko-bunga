<?php
include "config/koneksi.php";

$produk = mysqli_query($koneksi,"
SELECT * FROM produk
ORDER BY id_produk DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Toko Bunga Online</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header>
    <div class="logo">🌸 Toko Bunga</div>

    <nav>
        <a href="index.php">Home</a>
        <a href="keranjang.php">Keranjang</a>
        <a href="pelanggan/login.php">Login</a>
    </nav>
</header>

<section class="hero">
    <h1>Bunga Segar Untuk Orang Tersayang</h1>
    <p>Pesan bunga dengan mudah dan cepat</p>
</section>

<div class="container">

<?php while($p=mysqli_fetch_array($produk)){ ?>

<div class="card">

<img src="uploads/<?= $p['gambar']; ?>">

<h3><?= $p['nama_bunga']; ?></h3>

<h4>
Rp <?= number_format($p['harga']); ?>
</h4>

<a href="detail.php?id=<?= $p['id_produk']; ?>">
Lihat Detail
</a>

</div>

<?php } ?>

</div>

</body>
</html>