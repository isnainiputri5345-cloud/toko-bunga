<?php
include "../config/koneksi.php";

$data=mysqli_query($koneksi,"
SELECT *
FROM pesanan
WHERE status='Selesai'
");

$total=0;

while($d=mysqli_fetch_array($data)){
$total += $d['total'];
}
?>

<?php include "sidebar.php"; ?>

<div class="content">

<h2>Laporan Penjualan</h2>

<h3>
Total Pendapatan :
Rp <?= number_format($total); ?>
</h3>

</div>