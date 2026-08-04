<?php
session_start();

include "config/koneksi.php";

/*=========================================
  CEK LOGIN
=========================================*/

if (!isset($_SESSION['id_pelanggan'])) {

    header("Location: pelanggan/login.php");
    exit;

}

$id_pelanggan = $_SESSION['id_pelanggan'];


/*=========================================
  AMBIL DATA PELANGGAN
=========================================*/

$queryPelanggan = mysqli_query($koneksi, "
SELECT *
FROM pelanggan
WHERE id_pelanggan='$id_pelanggan'
");

$pelanggan = mysqli_fetch_assoc($queryPelanggan);


/*=========================================
  CEK KERANJANG
=========================================*/

if (
    !isset($_SESSION['keranjang']) ||
    count($_SESSION['keranjang']) == 0
) {

    header("Location: keranjang.php");
    exit;

}


/*=========================================
  AMBIL DATA PRODUK
=========================================*/

$produk_checkout = [];

$total = 0;

foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {

    $queryProduk = mysqli_query($koneksi, "
    SELECT *
    FROM produk
    WHERE id_produk='$id_produk'
    ");

    if (mysqli_num_rows($queryProduk) > 0) {

        $produk = mysqli_fetch_assoc($queryProduk);

        $subtotal = $produk['harga'] * $jumlah;

        $total += $subtotal;

        $produk_checkout[] = [

            "id_produk" => $produk['id_produk'],

            "nama_bunga" => $produk['nama_bunga'],

            "harga" => $produk['harga'],

            "gambar" => $produk['gambar'],

            "jumlah" => $jumlah,

            "subtotal" => $subtotal

        ];

    }

}


/*=========================================
  PROSES CHECKOUT
=========================================*/

if (isset($_POST['checkout'])) {

    date_default_timezone_set("Asia/Jakarta");

    $tanggal = date("Y-m-d H:i:s");

$status = "Menunggu";

$tanggal_pesan = date("Y-m-d");

    mysqli_query($koneksi, "
    INSERT INTO pesanan
    (
        id_pelanggan,
        tanggal,
        total,
        status,
        tanggal_pesan,
        total_harga
    )

    VALUES
    (
        '$id_pelanggan',
        '$tanggal',
        '$total',
        '$status',
        '$tanggal_pesan',
        '$total'
    )
    ");

    $id_pesanan = mysqli_insert_id($koneksi);


    /*=====================================
      SIMPAN DETAIL PESANAN
    =====================================*/

    foreach ($produk_checkout as $item) {

        $id_produk = $item['id_produk'];

        $jumlah = $item['jumlah'];

        $subtotal = $item['subtotal'];

        mysqli_query($koneksi, "
        INSERT INTO detail_pesanan
        (
            id_pesanan,
            id_produk,
            jumlah,
            subtotal
        )

        VALUES
        (
            '$id_pesanan',
            '$id_produk',
            '$jumlah',
            '$subtotal'
        )
        ");

    }


    /*=====================================
      HAPUS KERANJANG
    =====================================*/

    unset($_SESSION['keranjang']);


    /*=====================================
      PINDAH KE KONFIRMASI PEMBAYARAN
    =====================================*/

    header("Location: konfirmasi_pembayaran.php?id=".$id_pesanan);

    exit;

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Checkout | Erlisna Florist</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<?php include "includes/header.php"; ?>

<section class="page-header">

<div class="container">

<h1>

<i class="fa-solid fa-bag-shopping"></i>

Checkout Pesanan

</h1>

<p>

Periksa kembali pesanan Anda sebelum melanjutkan ke pembayaran.

</p>

</div>

</section>

<div class="container">

<form method="POST" class="checkout-form">

<div class="checkout-left">

<!-- ===========================
DATA PEMBELI
=========================== -->

<div class="checkout-card">

<h2>

<i class="fa-solid fa-user"></i>

Data Pembeli

</h2>

<div class="form-group">

<label>Nama Lengkap</label>

<input
type="text"
value="<?= htmlspecialchars($pelanggan['nama']); ?>"
readonly>

</div>

<div class="form-group">

<label>Nomor Telepon</label>

<input
type="text"
value="<?= htmlspecialchars($pelanggan['telepon']); ?>"
readonly>

</div>

<div class="form-group">

<label>Alamat Pengiriman</label>

<textarea rows="4" readonly><?= htmlspecialchars($pelanggan['alamat']); ?></textarea>

</div>

</div>

<!-- ===========================
DETAIL PESANAN
=========================== -->

<div class="checkout-card">

<h2>

<i class="fa-solid fa-cart-shopping"></i>

Detail Pesanan

</h2>

<?php foreach($produk_checkout as $item){ ?>

<div class="checkout-product">

<div class="checkout-image">

<img
src="uploads/<?= htmlspecialchars($item['gambar']); ?>"
alt="<?= htmlspecialchars($item['nama_bunga']); ?>">

</div>

<div class="checkout-info">

<h3>

<?= htmlspecialchars($item['nama_bunga']); ?>

</h3>

<p>

Harga :

<strong>

Rp <?= number_format($item['harga'],0,",","."); ?>

</strong>

</p>

<p>

Jumlah :

<strong>

<?= $item['jumlah']; ?>

</strong>

</p>

<p>

Subtotal :

<strong class="subtotal">

Rp <?= number_format($item['subtotal'],0,",","."); ?>

</strong>

</p>

</div>

</div>

<hr>

<?php } ?>

</div>

</div>

<!-- ===========================
RINGKASAN BELANJA
=========================== -->

<div class="checkout-right">

<div class="checkout-card total-box">

<h2>

Ringkasan Belanja

</h2>

<div class="summary-item">

<span>Total Produk</span>

<strong>

<?= count($produk_checkout); ?>

Item

</strong>

</div>

<div class="summary-item">

<span>Total Pembayaran</span>

<strong class="grand-total">

Rp <?= number_format($total,0,",","."); ?>

</strong>

</div>

<p class="checkout-note">

Setelah menekan tombol <b>Buat Pesanan</b>,
Anda akan diarahkan ke halaman
<strong>Konfirmasi Pembayaran</strong>
untuk memilih metode pembayaran
dan mengunggah bukti transfer.

</p>

<button
type="submit"
name="checkout"
class="btn-checkout">

<i class="fa-solid fa-check"></i>

Buat Pesanan

</button>

</div>

</div>

</form>

</div>

<?php include "includes/footer.php"; ?>

</body>

</html>