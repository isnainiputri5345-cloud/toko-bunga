<?php
session_start();
include "config/koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query($koneksi,"
SELECT produk.*, kategori.nama_kategori
FROM produk
LEFT JOIN kategori
ON produk.id_kategori=kategori.id_kategori
WHERE id_produk='$id'
");

$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    echo "<script>
    alert('Produk tidak ditemukan');
    window.location='produk.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
<?= $produk['nama_bunga']; ?>
-
Erlisna Florist
</title>

<link rel="stylesheet"
href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<?php include "includes/header.php"; ?>

<section class="detail-section">

<div class="container detail-container">

<div class="detail-image">

<img
src="uploads/<?= $produk['gambar']; ?>"
alt="<?= $produk['nama_bunga']; ?>">

</div>

<div class="detail-info">

<span class="kategori">

<?= $produk['nama_kategori']; ?>

</span>

<h1>

<?= $produk['nama_bunga']; ?>

</h1>

<div class="harga">

Rp <?= number_format($produk['harga'],0,",","."); ?>

</div>

<p class="stok">

<i class="fa fa-box"></i>

Stok :

<b><?= $produk['stok']; ?></b>

</p>

<div class="deskripsi">

<?= nl2br($produk['deskripsi']); ?>

</div>

<form
action="keranjang.php"
method="POST">

<input
type="hidden"
name="id_produk"
value="<?= $produk['id_produk']; ?>">

<label>

Jumlah

</label>

<input
type="number"
name="jumlah"
value="1"
min="1"
max="<?= $produk['stok']; ?>">

<div class="detail-button">

<button
type="submit"
name="tambah"
class="btn-cart">

<i class="fa fa-cart-plus"></i>

Tambah ke Keranjang

</button>

<button
type="submit"
name="beli"
class="btn-buy">

<i class="fa fa-credit-card"></i>

Beli Sekarang

</button>

</div>

</form>

</div>

</div>

</section>

<!-- PRODUK TERKAIT -->

<section class="section">

<div class="container">

<div class="section-title">

<h2>

Produk Lainnya

</h2>

</div>

<div class="product-grid">

<?php

$related=mysqli_query($koneksi,"
SELECT *
FROM produk
WHERE id_produk!='$id'
LIMIT 4
");

while($r=mysqli_fetch_assoc($related)){

?>

<div class="card">

<img
src="uploads/<?= $r['gambar']; ?>">

<div class="card-body">

<h3>

<?= $r['nama_bunga']; ?>

</h3>

<div class="price">

Rp
<?= number_format($r['harga'],0,",","."); ?>

</div>

<a
href="detail.php?id=<?= $r['id_produk']; ?>"
class="btn-primary">

Lihat Detail

</a>

</div>

</div>

<?php } ?>

</div>

</div>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>