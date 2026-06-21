<?php
session_start();
include "config/koneksi.php";

if(!isset($_SESSION['id_pelanggan'])){

echo "<script>
alert('Silahkan login terlebih dahulu');
window.location='login.php';
</script>";

exit;
}

if(isset($_POST['beli'])){

$id_produk = $_POST['id_produk'];
$jumlah = $_POST['jumlah'];

$_SESSION['keranjang'][$id_produk] = $jumlah;
}

if(isset($_GET['hapus'])){

unset(
$_SESSION['keranjang'][$_GET['hapus']]
);

header("Location:keranjang.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Keranjang</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container">

<h1>Keranjang Belanja</h1>

<table class="cart-table">

<tr>

<th>Produk</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Subtotal</th>
<th>Aksi</th>

</tr>

<?php

$total = 0;

if(isset($_SESSION['keranjang'])){

foreach(
$_SESSION['keranjang']
as $id_produk => $jumlah
){

$data = mysqli_query($koneksi,"
SELECT *
FROM produk
WHERE id_produk='$id_produk'
");

$p = mysqli_fetch_assoc($data);

$subtotal =
$p['harga'] * $jumlah;

$total += $subtotal;
?>

<tr>

<td>

<img
src="uploads/<?= $p['gambar']; ?>"
width="80">

<br>

<?= $p['nama_bunga']; ?>

</td>

<td>
Rp <?= number_format($p['harga']); ?>
</td>

<td>
<?= $jumlah; ?>
</td>

<td>
Rp <?= number_format($subtotal); ?>
</td>

<td>

<a
href="?hapus=<?= $id_produk; ?>"
class="btn-delete">

Hapus

</a>

</td>

</tr>

<?php
}}
?>

<tr>

<td colspan="3">

<b>Total Belanja</b>

</td>

<td colspan="2">

<b>
Rp <?= number_format($total); ?>
</b>

</td>

</tr>

</table>

<div class="cart-action">

<a href="produk.php"
class="btn-secondary">

Lanjut Belanja

</a>

<a href="checkout.php"
class="btn-primary">

Checkout

</a>

</div>

</div>

</body>
</html>