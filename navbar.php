<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<header>

    <div class="logo">
        🌸 ERLISNA FLORIST
    </div>

    <nav>

        <a href="index.php">Beranda</a>

        <a href="produk.php">Produk</a>

        <a href="tentang.php">Tentang Kami</a>

        <?php if(isset($_SESSION['id_pelanggan'])){ ?>

            <a href="pelanggan/dashboard.php">
                Dashboard
            </a>

            <a href="keranjang.php">
                Keranjang
            </a>

            <a href="pelanggan/riwayat.php">
                Pesanan Saya
            </a>

            <a href="pelanggan/profil.php">
                <?= $_SESSION['nama']; ?>
            </a>

            <a href="pelanggan/logout.php">
                Logout
            </a>

        <?php } else { ?>

            <a href="login.php">
                Login
            </a>

            <a href="register.php">
                Register
            </a>

            <a href="admin/login.php">
                Admin
            </a>

        <?php } ?>

    </nav>

</header>