<?php
session_start();
include "config/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi,"
SELECT * FROM produk
WHERE id_produk='$id'
");

$p = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<div class="detail-container">

    <div class="detail-gambar">
        <img src="uploads/<?php echo $p['gambar']; ?>">
    </div>

    <div class="detail-info">

        <h1><?php echo $p['nama_bunga']; ?></h1>

        <h2>
            Rp <?php echo number_format($p['harga']); ?>
        </h2>

        <p>
            Stok : <?php echo $p['stok']; ?>
        </p>

        <hr>

        <p>
            <?php echo nl2br($p['deskripsi']); ?>
        </p>

        <br>

        <?php if(isset($_SESSION['id_pelanggan'])){ ?>

            <form action="keranjang.php" method="POST">

                <input
                    type="hidden"
                    name="id_produk"
                    value="<?php echo $p['id_produk']; ?>">

                <label>Jumlah :</label>

                <input
                    type="number"
                    name="jumlah"
                    value="1"
                    min="1"
                    max="<?php echo $p['stok']; ?>"
                    required>

                <button
                    type="submit"
                    name="beli"
                    class="btn-pesan">

                    Tambah ke Keranjang

                </button>

            </form>

        <?php } else { ?>

            <a href="pelanggan/login.php" class="btn-login">

                Login Untuk Memesan

            </a>

        <?php } ?>

    </div>

</div>

</body>
</html>