<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$data=mysqli_query($koneksi,"
SELECT *
FROM pesanan
");

$total=0;

while($d=mysqli_fetch_array($data)){

$total += $d['total'];

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Laporan</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Laporan Penjualan</h1>

<div class="laporan-box">

<h2>

Total Pendapatan

</h2>

<h1>

Rp <?= number_format($total); ?>

</h1>

</div>

</div>

</body>
</html>