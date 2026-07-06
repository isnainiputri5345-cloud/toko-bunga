<footer>

<div class="container">

<div class="footer-grid">

    <!-- Logo -->
    <div class="footer-item">

        <img src="assets/images/logo.png" class="footer-logo">

        <h2>ERLISNA FLORIST</h2>

        <p>
            Kami menyediakan berbagai rangkaian bunga segar
            berkualitas untuk wisuda, ulang tahun, pernikahan,
            standing flower, papan bunga, dan berbagai momen
            spesial lainnya.
        </p>

    </div>

    <!-- Menu -->
    <div class="footer-item">

        <h3>Menu</h3>

        <a href="index.php">Beranda</a>

        <a href="produk.php">Produk</a>

        <a href="tentang.php">Tentang Kami</a>

        <a href="kontak.php">Kontak Kami</a>

    </div>

    <!-- Kategori -->
    <div class="footer-item">

        <h3>Kategori</h3>

        <?php

        $kategori_footer=mysqli_query($koneksi,"
        SELECT * FROM kategori
        ORDER BY nama_kategori ASC
        ");

        while($k=mysqli_fetch_assoc($kategori_footer)){

        ?>

        <a href="produk.php?kategori=<?= $k['id_kategori']; ?>">

            <?= $k['nama_kategori']; ?>

        </a>

        <?php } ?>

    </div>

    <!-- Kontak -->
    <div class="footer-item">

        <h3>Hubungi Kami</h3>

        <p>

            <i class="fa-solid fa-location-dot"></i>

            Jl. Raya Denpasar, Bali

        </p>

        <p>

            <i class="fa-solid fa-phone"></i>

            0812-3456-7890

        </p>

        <p>

            <i class="fa-solid fa-envelope"></i>

            erlisnaflorist@gmail.com

        </p>

        <p>

            <i class="fa-brands fa-instagram"></i>

            @erlisnaflorist

        </p>

    </div>

</div>

<hr>

<div class="copyright">

© <?= date("Y"); ?>

ERLISNA FLORIST

|

All Rights Reserved.

</div>

</div>

</footer>

</body>
</html>