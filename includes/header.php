<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . "/../config/koneksi.php";

$is_pelanggan = basename(dirname($_SERVER['SCRIPT_NAME'])) == "pelanggan";

$base_root = $is_pelanggan ? "../" : "";
$base_pelanggan = $is_pelanggan ? "" : "pelanggan/";

/* ==========================
   AMBIL DATA KATEGORI
========================== */

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

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Erlisna Florist</title>

<link rel="stylesheet"
href="<?= $base_root ?>assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<header>

<div class="container">

<div class="topbar">


<!-- =======================
LOGO
======================= -->

<div class="logo">

<a href="<?= $base_root ?>index.php">

<img src="<?= $base_root ?>assets/images/logo.png"
alt="Logo">

</a>

<div>

<h2>ERLISNA FLORIST</h2>

<p>Fresh Flower & Bouquet</p>

</div>

</div>



<!-- =======================
MENU
======================= -->

<nav>

<a href="<?= $base_root ?>index.php">

<i class="fa-solid fa-house"></i>

Beranda

</a>



<!-- PRODUK -->

<div class="nav-dropdown">

<button
type="button"
class="dropdown-btn">

Produk

<i class="fa-solid fa-angle-down"></i>

</button>

<div class="dropdown-content">

<a href="<?= $base_root ?>produk.php">

Semua Produk

</a>

<?php while($k=mysqli_fetch_assoc($kategori)){ ?>

<a href="<?= $base_root ?>produk.php?kategori=<?= $k['id_kategori']; ?>">

<?= htmlspecialchars($k['nama_kategori']); ?>

</a>

<?php } ?>

</div>

</div>



<a href="<?= $base_root ?>tentang.php">

Tentang Kami

</a>


<a href="<?= $base_root ?>kontak.php">

Kontak

</a>

</nav>





<!-- =======================
SEARCH
======================= -->

<form
action="<?= $base_root ?>produk.php"
method="GET"
class="search-box">

<input
type="text"
name="cari"
placeholder="Cari bunga...">

<button type="submit">

<i class="fa fa-search"></i>

</button>

</form>





<!-- =======================
ICON
======================= -->

<div class="header-icon">


<a href="<?= $base_root ?>keranjang.php">

<i class="fa-solid fa-cart-shopping"></i>

<?php
if(isset($_SESSION['keranjang'])){
?>

<span class="cart-count">

<?= count($_SESSION['keranjang']); ?>

</span>

<?php } ?>

</a>




<?php if(isset($_SESSION['id_pelanggan'])){ ?>


<div class="nav-dropdown profil">

<button
type="button"
class="dropdown-btn">

<i class="fa-solid fa-user"></i>

<?= htmlspecialchars($_SESSION['nama']); ?>

<i class="fa-solid fa-angle-down"></i>

</button>


<div class="dropdown-content">

<a href="<?= $base_root ?>pelanggan/dashboard.php">

Dashboard

</a>

<a href="<?= $base_root ?>pelanggan/profil.php">

Profil Saya

</a>

<a href="<?= $base_root ?>pelanggan/edit_profil.php">

Edit Profil

</a>

<a href="<?= $base_root ?>pelanggan/riwayat.php">

Pesanan Saya

</a>

<a href="<?= $base_root ?>pelanggan/chat.php">

💬 Konsultasi Buket

</a>

<hr>

<a class="logout"
href="<?= $base_root ?>pelanggan/logout.php">

Logout

</a>

</div>

</div>


<?php }else{ ?>


<a
href="<?= $base_root ?>pelanggan/login.php"
class="login-btn">

Login

</a>

<a
href="<?= $base_root ?>pelanggan/register.php"
class="register-btn">

Daftar

</a>

<a
href="<?= $base_root ?>admin/login.php"
class="admin-btn">

Admin

</a>

<?php } ?>

</div>

</div>

</div>

</header>