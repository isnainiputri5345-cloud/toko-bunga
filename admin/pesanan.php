<?php
include "../config/koneksi.php";
?>

<?php include "sidebar.php"; ?>

<div class="content">

<h2>Data Pesanan</h2>

<table>

<tr>
<th>ID</th>
<th>Pelanggan</th>
<th>Tanggal</th>
<th>Total</th>
<th>Status</th>
</tr>

<?php

$data=mysqli_query($koneksi,"
SELECT *
FROM pesanan
JOIN pelanggan
ON pesanan.id_pelanggan=pelanggan.id_pelanggan
");

while($d=mysqli_fetch_array($data)){
?>

<tr>

<td>#<?= $d['id_pesanan']; ?></td>

<td><?= $d['nama']; ?></td>

<td><?= $d['tanggal']; ?></td>

<td>
Rp <?= number_format($d['total']); ?>
</td>

<td><?= $d['status']; ?></td>

</tr>

<?php } ?>

</table>

</div>