<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id=$_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Pesanan</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<?php include "../navbar.php"; ?>

<div class="container">

<h1>Detail Pesanan</h1>

<table class="cart-table">

<tr>

<th>Produk</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Subtotal</th>

</tr>

<?php

$data=mysqli_query($koneksi,"
SELECT *
FROM detail_pesanan
JOIN produk
ON detail_pesanan.id_produk=
produk.id_produk
WHERE id_pesanan='$id'
");

while($d=mysqli_fetch_assoc($data)){
?>

<tr>

<td>
<?= $d['nama_bunga']; ?>
</td>

<td>
Rp <?= number_format($d['harga']); ?>
</td>

<td>
<?= $d['jumlah']; ?>
</td>

<td>
Rp <?= number_format($d['subtotal']); ?>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>