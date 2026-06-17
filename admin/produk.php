<?php
include "../config/koneksi.php";
?>

<?php include "sidebar.php"; ?>

<div class="content">

<h2>Data Produk</h2>

<a href="tambah_produk.php">
Tambah Produk
</a>

<table>

<tr>
<th>Gambar</th>
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
ON produk.id_kategori=kategori.id_kategori
");

while($d=mysqli_fetch_array($data)){
?>

<tr>

<td>
<img src="../uploads/<?= $d['gambar']; ?>"
width="80">
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