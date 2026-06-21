<?php

session_start();

if(!isset($_SESSION['admin'])){
header("Location:login.php");
}

include "../config/koneksi.php";

$produk =
mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM produk")
);

$kategori =
mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM kategori")
);

$pesanan =
mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM pesanan")
);

$pelanggan =
mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM pelanggan")
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

<h1>
Dashboard Admin
</h1>

<div class="cards">

<div class="card">
<h2><?= $produk ?></h2>
<p>Produk</p>
</div>

<div class="card">
<h2><?= $kategori ?></h2>
<p>Kategori</p>
</div>

<div class="card">
<h2><?= $pesanan ?></h2>
<p>Pesanan</p>
</div>

<div class="card">
<h2><?= $pelanggan ?></h2>
<p>Pelanggan</p>
</div>

</div>

</div>

</body>
</html>