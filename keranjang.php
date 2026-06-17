<?php
session_start();
include "config/koneksi.php";

if(!isset($_SESSION['id_pelanggan'])){

    echo "
    <script>
    alert('Silahkan login terlebih dahulu');
    window.location='pelanggan/login.php';
    </script>";
    exit;
}

/* TAMBAH KE KERANJANG */

if(isset($_POST['beli'])){

    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    if(isset($_SESSION['keranjang'][$id_produk])){

        $_SESSION['keranjang'][$id_produk] += $jumlah;

    }else{

        $_SESSION['keranjang'][$id_produk] = $jumlah;
    }
}

/* HAPUS ITEM */

if(isset($_GET['hapus'])){

    unset($_SESSION['keranjang'][$_GET['hapus']]);

    header("Location: keranjang.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include "navbar.php"; ?>

<div class="container">

<h1>Keranjang Belanja</h1>

<table class="table">

<tr>
    <th>Gambar</th>
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
    <th>Aksi</th>
</tr>

<?php

$total = 0;

if(!empty($_SESSION['keranjang'])){

foreach($_SESSION['keranjang'] as $id_produk => $jumlah){

$data = mysqli_query($koneksi,"
SELECT * FROM produk
WHERE id_produk='$id_produk'
");

$p = mysqli_fetch_assoc($data);

$subtotal = $p['harga'] * $jumlah;

$total += $subtotal;
?>

<tr>

<td>

<img
src="uploads/<?php echo $p['gambar']; ?>"
width="80">

</td>

<td>
<?php echo $p['nama_bunga']; ?>
</td>

<td>
Rp <?php echo number_format($p['harga']); ?>
</td>

<td>
<?php echo $jumlah; ?>
</td>

<td>
Rp <?php echo number_format($subtotal); ?>
</td>

<td>

<a
href="keranjang.php?hapus=<?php echo $id_produk; ?>"
onclick="return confirm('Hapus produk ini?')"
class="btn-hapus">

Hapus

</a>

</td>

</tr>

<?php
}
}
?>

<tr>

<td colspan="4">
<b>Total Belanja</b>
</td>

<td colspan="2">
<b>
Rp <?php echo number_format($total); ?>
</b>
</td>

</tr>

</table>

<div class="aksi-keranjang">

<a href="produk.php" class="btn-lanjut">

← Lanjut Belanja

</a>

<?php if($total > 0){ ?>

<a href="checkout.php" class="btn-checkout">

Checkout →

</a>

<?php } ?>

</div>

</div>

</body>
</html>