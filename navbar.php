<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
// Tentukan base path berdasarkan lokasi berkas saat ini
$is_pelanggan_dir = basename(dirname($_SERVER['SCRIPT_NAME'])) == 'pelanggan';
$base_root = $is_pelanggan_dir ? '../' : './';
$base_pelanggan = $is_pelanggan_dir ? './' : 'pelanggan/';
?>

<header>

    <div class="logo" img src="<?= $base_root; ?>assets/images/logo.png" alt="logo" width: 100px;>
        🌸 ERLISNA FLORIST
    </div>

    <nav>

        <a href="<?= $base_root; ?>index.php">Beranda</a>

        <a href="<?= $base_root; ?>produk.php">Produk</a>

        <a href="<?= $base_root; ?>tentang.php">Tentang Kami</a>

        <?php if(isset($_SESSION['id_pelanggan'])){ ?>

            <a href="<?= $base_pelanggan; ?>dashboard.php">
                Dashboard
            </a>

            <a href="<?= $base_root; ?>keranjang.php">
                Keranjang
            </a>

            <a href="<?= $base_pelanggan; ?>riwayat.php">
                Pesanan Saya
            </a>

            <a href="<?= $base_pelanggan; ?>profil.php">
                <?= $_SESSION['nama']; ?>
            </a>

            <a href="<?= $base_pelanggan; ?>logout.php">
                Logout
            </a>

        <?php } else { ?>

            <a href="<?= $base_pelanggan; ?>login.php">
                Login
            </a>

            <a href="<?= $base_pelanggan; ?>register.php">
                Register
            </a>

            <a href="<?= $base_root; ?>admin/login.php">
                Admin
            </a>

        <?php } ?>

    </nav>

</header>