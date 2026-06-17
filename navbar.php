<?php
session_start();
?>

<header>

    <div class="logo">
        🌸 FlowerShop
    </div>

    <nav>

        <a href="index.php">Beranda</a>

        <a href="produk.php">Produk</a>

        <a href="tentang.php">Tentang Kami</a>

        <?php if(isset($_SESSION['id_pelanggan'])){ ?>

            <a href="keranjang.php">Keranjang</a>

            <a href="profil.php">
                <?= $_SESSION['nama']; ?>
            </a>

            <a href="logout.php">Logout</a>

        <?php } else { ?>

            <a href="pelanggan/login.php">
                Login Pelanggan
            </a>

            <a href="admin/login.php">
                Login Admin
            </a>

        <?php } ?>

    </nav>

</header>