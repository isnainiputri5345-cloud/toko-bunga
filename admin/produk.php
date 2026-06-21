<?php
include "../config/koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Produk</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Data Produk</h1>

<a
href="tambah_produk.php"
class="btn">

Tambah Produk

</a>

<table>

<tr>

<th>Foto</th>
<th>Nama</th>
<th>Kategori</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>

</tr>

<?php

$data=mysqli_query($koneksi,"
SELECT *
FROM produk
JOIN kategori
ON produk.id_kategori=
kategori.id_kategori
");

while($d=mysqli_fetch_array($data)){
?>

<tr>

<td>
<img
src="../uploads/<?= $d['gambar']; ?>"
width="70">
</td>

<td><?= $d['nama_bunga']; ?></td>

<td><?= $d['nama_kategori']; ?></td>

<td>
Rp <?= number_format($d['harga']); ?>
</td>

<td><?= $d['stok']; ?></td>

<td>

<a href="edit_produk.php?id=<?= $d['id_produk']; ?>">
Edit
</a>

|

<a href="hapus_produk.php?id=<?= $d['id_produk']; ?>">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>