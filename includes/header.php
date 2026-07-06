<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include_once __DIR__ . "/../config/koneksi.php";

/* ===========================
   Ambil Data Kategori
=========================== */

$kategori = mysqli_query($koneksi,"
SELECT *
FROM kategori
ORDER BY nama_kategori ASC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Erlisna Florist</title>

<link rel="stylesheet"
href="assets/css/style.css">

<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<header>

<div class="container">

<div class="topbar">

<!-- ================= LOGO ================= -->

<div class="logo">

<a href="index.php">

<img
src="assets/images/logo.png"
alt="Logo">

</a>

<div>

<h2>ERLISNA FLORIST</h2>

<p>
Fresh Flower & Bouquet
</p>

</div>

</div>

<!-- ================= MENU ================= -->

<nav>

<a href="index.php">

<i class="fa-solid fa-house"></i>

Beranda

</a>

<!-- ================= DROPDOWN ================= -->

<div class="dropdown">

<a href="produk.php">

Produk

<i class="fa-solid fa-angle-down"></i>

</a>

<div class="dropdown-content">

<?php
while($k=mysqli_fetch_assoc($kategori)){
?>

<a href="produk.php?kategori=<?= $k['id_kategori']; ?>">

<?= $k['nama_kategori']; ?>

</a>

<?php } ?>

</div>

</div>

<a href="tentang.php">

Tentang Kami

</a>

<a href="kontak.php">

Kontak

</a>

</nav>

<!-- ================= SEARCH ================= -->

<form
action="produk.php"
method="GET"
class="search-box">

<input

type="text"

name="cari"

placeholder="Cari bunga...">

<button>

<i class="fa fa-search"></i>

</button>

</form>

<!-- ================= ICON ================= -->

<div class="header-icon">

<a href="keranjang.php">

<i class="fa-solid fa-cart-shopping"></i>

<?php

if(isset($_SESSION['keranjang'])){

echo "<span>".count($_SESSION['keranjang'])."</span>";

}

?>

</a>

<?php

if(isset($_SESSION['id_pelanggan'])){

?>

<div class="akun">

<i class="fa-solid fa-user"></i>

<span>

<?= $_SESSION['nama']; ?>

</span>

<div class="akun-menu">

<a href="pelanggan/dashboard.php">

Dashboard

</a>

<a href="pelanggan/profil.php">

Profil

</a>

<a href="pelanggan/riwayat.php">

Pesanan Saya

</a>

<a href="pelanggan/logout.php">

Logout

</a>

</div>

</div>

<?php

}else{

?>

<a
href="login.php"
class="login-btn">

Login

</a>

<a
href="register.php"
class="register-btn">

Daftar

</a>

<a
href="admin/login.php"
class="admin-btn">

Admin

</a>

<?php } ?>

</div>

</div>

</div>

</header>