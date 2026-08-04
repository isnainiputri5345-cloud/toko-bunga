<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

$is_pelanggan_dir = basename(dirname($_SERVER['SCRIPT_NAME'])) == 'pelanggan';

$base_root = $is_pelanggan_dir ? '../' : './';
$base_pelanggan = $is_pelanggan_dir ? './' : 'pelanggan/';
?>


<header>

<div class="logo">

<img src="<?= $base_root; ?>assets/images/logo.png" 
alt="logo">

<span>
🌸 ERLISNA FLORIST
</span>

</div>


<nav>


<a href="<?= $base_root; ?>index.php">
Beranda
</a>



<!-- DROPDOWN PRODUK -->

<div class="nav-dropdown">

<a href="#" class="dropdown-btn">
Produk ▼
</a>


<div class="dropdown-content">


<a href="<?= $base_root; ?>produk.php">
Semua Produk
</a>


<a href="<?= $base_root; ?>produk.php?kategori=1">
Buket Bunga Asli
</a>


<a href="<?= $base_root; ?>produk.php?kategori=2">
Buket Wisuda
</a>


<a href="<?= $base_root; ?>produk.php?kategori=3">
Buket Ulang Tahun
</a>


<a href="<?= $base_root; ?>produk.php?kategori=4">
Buket Rajut
</a>


<a href="<?= $base_root; ?>produk.php?kategori=5">
Papan Bunga
</a>


</div>

</div>



<a href="<?= $base_root; ?>tentang.php">
Tentang Kami
</a>



<?php if(isset($_SESSION['id_pelanggan'])){ ?>


<a href="<?= $base_root; ?>keranjang.php">
🛒 Keranjang
</a>


<a href="<?= $base_pelanggan; ?>riwayat.php">
Pesanan Saya
</a>


<a href="<?= $base_pelanggan; ?>chat.php">
💬 Konsultasi Buket
</a>



<!-- DROPDOWN PROFIL -->

<div class="nav-dropdown profil">


<a href="#" class="dropdown-btn">

<i class="fa fa-user"></i>

<?= $_SESSION['nama']; ?>

▼

</a>



<div class="dropdown-content">


<a href="<?= $base_pelanggan; ?>dashboard.php">
👤 Profil Saya
</a>


<a href="<?= $base_pelanggan; ?>edit_profil.php">
✏ Edit Profil
</a>


<a href="<?= $base_pelanggan; ?>riwayat.php">
📦 Riwayat Pesanan
</a>


<hr>


<a class="logout"
href="<?= $base_pelanggan; ?>logout.php">
🚪 Logout
</a>


</div>


</div>



<?php }else{ ?>


<a href="<?= $base_pelanggan; ?>login.php">
Login
</a>


<a href="<?= $base_pelanggan; ?>register.php">
Register
</a>


<?php } ?>


</nav>


</header>