<?php
session_start();
include "../config/koneksi.php";
?>

<?php include "sidebar.php"; ?>

<div class="content">

<h2>Data Kategori</h2>

<a href="tambah_kategori.php" class="btn">
Tambah Kategori
</a>

<table>

<tr>
<th>No</th>
<th>Nama Kategori</th>
<th>Aksi</th>
</tr>

<?php

$no=1;

$data = mysqli_query($koneksi,"
SELECT * FROM kategori
");

while($d=mysqli_fetch_array($data)){
?>

<tr>

<td><?= $no++ ?></td>

<td><?= $d['nama_kategori'] ?></td>

<td>

<a href="edit_kategori.php?id=<?= $d['id_kategori'] ?>">
Edit</a>

|

<a href="hapus_kategori.php?id=<?= $d['id_kategori'] ?>">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</div>