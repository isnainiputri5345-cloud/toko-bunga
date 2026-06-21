<?php
include "config/koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Produk - Erlisna Florist</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include "navbar.php"; ?>

<section class="page-header">
<h1>Produk Kami</h1>
<p>Pilih bunga terbaik untuk orang tersayang</p>
</section>

<div class="produk-container">

<?php

$data = mysqli_query($koneksi,"
SELECT * FROM produk
ORDER BY id_produk DESC
");

while($p=mysqli_fetch_array($data)){
?>

<div class="produk-card">

<img src="uploads/<?= $p['gambar']; ?>">

<div class="produk-body">

<h3><?= $p['nama_bunga']; ?></h3>

<h4>
Rp <?= number_format($p['harga']); ?>
</h4>

<p>
Stok : <?= $p['stok']; ?>
</p>

<a href="detail.php?id=<?= $p['id_produk']; ?>">
Lihat Detail
</a>

</div>

</div>

<?php } ?>

</div>

</body>
</html>