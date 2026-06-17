<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("location:login.php");
}

include "../config/koneksi.php";

$produk = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM produk"));
$kategori = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM kategori"));
$pesanan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM pesanan"));
$pelanggan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM pelanggan"));
?>

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Dashboard Admin</h1>

<div class="cards">

<div class="card">
<h3><?= $produk ?></h3>
<p>Produk</p>
</div>

<div class="card">
<h3><?= $kategori ?></h3>
<p>Kategori</p>
</div>

<div class="card">
<h3><?= $pesanan ?></h3>
<p>Pesanan</p>
</div>

<div class="card">
<h3><?= $pelanggan ?></h3>
<p>Pelanggan</p>
</div>

</div>

</div>