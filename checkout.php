<?php
session_start();
include "config/koneksi.php";

if(!isset($_SESSION['id_pelanggan'])){

header("Location:login.php");
exit;
}

$id_pelanggan =
$_SESSION['id_pelanggan'];

$data = mysqli_query($koneksi,"
SELECT *
FROM pelanggan
WHERE id_pelanggan='$id_pelanggan'
");

$pelanggan =
mysqli_fetch_assoc($data);

$total = 0;

if(isset($_SESSION['keranjang'])){

foreach(
$_SESSION['keranjang']
as $id_produk=>$jumlah
){

$produk = mysqli_fetch_assoc(
mysqli_query(
$koneksi,
"SELECT * FROM produk
WHERE id_produk='$id_produk'"
));

$total +=
$produk['harga'] * $jumlah;

}
}

if(isset($_POST['checkout'])){

$tanggal = date('Y-m-d H:i:s');

mysqli_query($koneksi,"
INSERT INTO pesanan(
id_pelanggan,
tanggal,
total,
status
)
VALUES(
'$id_pelanggan',
'$tanggal',
'$total',
'Menunggu'
)
");

$id_pesanan =
mysqli_insert_id($koneksi);

foreach(
$_SESSION['keranjang']
as $id_produk=>$jumlah
){

$produk = mysqli_fetch_assoc(
mysqli_query(
$koneksi,
"SELECT * FROM produk
WHERE id_produk='$id_produk'"
));

$subtotal =
$produk['harga'] * $jumlah;

mysqli_query($koneksi,"
INSERT INTO detail_pesanan(
id_pesanan,
id_produk,
jumlah,
subtotal
)
VALUES(
'$id_pesanan',
'$id_produk',
'$jumlah',
'$subtotal'
)
");

}

unset($_SESSION['keranjang']);

header("Location:selesai.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="checkout-box">

<h1>Checkout Pesanan</h1>

<form method="POST">

<label>Nama</label>

<input
type="text"
value="<?= $pelanggan['nama']; ?>"
readonly>

<label>Telepon</label>

<input
type="text"
value="<?= $pelanggan['telepon']; ?>"
readonly>

<label>Alamat</label>

<textarea readonly>
<?= $pelanggan['alamat']; ?>
</textarea>

<h2>
Total :
Rp <?= number_format($total); ?>
</h2>

<button
name="checkout">

Buat Pesanan

</button>

</form>

</div>

</body>
</html>