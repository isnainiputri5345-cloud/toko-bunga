<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id=$_SESSION['id_pelanggan'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Riwayat Pesanan</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<?php include "../navbar.php"; ?>

<div class="container">

<h1>Riwayat Pesanan</h1>

<table class="cart-table">

<tr>

<th>ID</th>
<th>Tanggal</th>
<th>Total</th>
<th>Status</th>
<th>Detail</th>

</tr>

<?php

$data=mysqli_query($koneksi,"
SELECT *
FROM pesanan
WHERE id_pelanggan='$id'
ORDER BY id_pesanan DESC
");

while($d=mysqli_fetch_assoc($data)){
?>

<tr>

<td>
#<?= $d['id_pesanan']; ?>
</td>

<td>
<?= $d['tanggal']; ?>
</td>

<td>
Rp <?= number_format($d['total']); ?>
</td>

<td>
<?= $d['status']; ?>
</td>

<td>

<a href="detail_pesanan.php?id=<?= $d['id_pesanan']; ?>">

Lihat

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>