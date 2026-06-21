<?php
session_start();
include "config/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi,"
SELECT *
FROM produk
WHERE id_produk='$id'
");

$p = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $p['nama_bunga']; ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="detail-container">

<div class="detail-image">

<img src="uploads/<?= $p['gambar']; ?>">

</div>

<div class="detail-content">

<h1><?= $p['nama_bunga']; ?></h1>

<h2>
Rp <?= number_format($p['harga']); ?>
</h2>

<p>
<?= nl2br($p['deskripsi']); ?>
</p>

<p>
<b>Stok :</b>
<?= $p['stok']; ?>
</p>

<?php if(isset($_SESSION['id_pelanggan'])){ ?>

<form method="POST"
action="keranjang.php">

<input
type="hidden"
name="id_produk"
value="<?= $p['id_produk']; ?>">

<label>Jumlah</label>

<input
type="number"
name="jumlah"
value="1"
min="1"
max="<?= $p['stok']; ?>">

<button
type="submit"
name="beli">

Tambah ke Keranjang

</button>

</form>

<?php }else{ ?>

<a href="login.php"
class="btn-login">

Login Untuk Memesan

</a>

<?php } ?>

</div>

</div>

</body>
</html>