<?php
session_start();

include "config/koneksi.php";

/*=========================================
 CEK LOGIN
=========================================*/

if(!isset($_SESSION['id_pelanggan'])){

    header("Location: pelanggan/login.php");
    exit;

}

$id_pelanggan=$_SESSION['id_pelanggan'];


/*=========================================
 CEK ID PESANAN
=========================================*/

if(!isset($_GET['id'])){

    header("Location: pelanggan/riwayat.php");
    exit;

}

$id_pesanan=(int)$_GET['id'];


/*=========================================
 AMBIL DATA PESANAN
=========================================*/

$query=mysqli_query($koneksi,"
SELECT
pesanan.*,
pelanggan.nama,
pelanggan.telepon,
pelanggan.alamat

FROM pesanan

JOIN pelanggan
ON pesanan.id_pelanggan=pelanggan.id_pelanggan

WHERE

pesanan.id_pesanan='$id_pesanan'

AND

pesanan.id_pelanggan='$id_pelanggan'

");

if(mysqli_num_rows($query)==0){

    die("Pesanan tidak ditemukan.");

}

$pesanan=mysqli_fetch_assoc($query);


/*=========================================
 CEK SUDAH PERNAH BAYAR
=========================================*/

$cek=mysqli_query($koneksi,"
SELECT *
FROM pembayaran
WHERE id_pesanan='$id_pesanan'
");

$sudah_bayar=mysqli_num_rows($cek);


/*=========================================
 PROSES KONFIRMASI
=========================================*/

if(isset($_POST['konfirmasi'])){

    if($sudah_bayar>0){

        echo "<script>

        alert('Pembayaran sudah pernah dikirim.');

        window.location='pelanggan/riwayat.php';

        </script>";

        exit;

    }


    $metode=mysqli_real_escape_string(

        $koneksi,

        $_POST['metode_pembayaran']

    );


date_default_timezone_set("Asia/Jakarta");

    $tanggal=date("Y-m-d");


    $namaFile="";


    /*=====================================
      UPLOAD BUKTI
    =====================================*/

    if(

        isset($_FILES['bukti'])

        &&

        $_FILES['bukti']['error']==0

    ){

        $folder="uploads/bukti/";

        if(!is_dir($folder)){

            mkdir($folder,0777,true);

        }

        $ext=strtolower(

            pathinfo(

                $_FILES['bukti']['name'],

                PATHINFO_EXTENSION

            )

        );

        $allowed=[

            "jpg",

            "jpeg",

            "png"

        ];

        if(!in_array($ext,$allowed)){

            echo "<script>

            alert('Format gambar harus JPG, JPEG atau PNG.');

            history.back();

            </script>";

            exit;

        }

        $namaFile=time()."_".rand(1000,9999).".".$ext;

        move_uploaded_file(

            $_FILES['bukti']['tmp_name'],

            $folder.$namaFile

        );

    }


    /*=====================================
      SIMPAN PEMBAYARAN
    =====================================*/

    mysqli_query($koneksi,"

    INSERT INTO pembayaran

    (

    id_pesanan,

    metode_pembayaran,

    tanggal_bayar,

    bukti_pembayaran,

    status_pembayaran

    )

    VALUES

    (

    '$id_pesanan',

    '$metode',

    '$tanggal',

'$namaFile',

    'Menunggu'

    )

    ");


    /*=====================================
      UPDATE STATUS PESANAN
    =====================================*/

    mysqli_query($koneksi,"

    UPDATE pesanan

    SET

    status='Menunggu'

    WHERE id_pesanan='$id_pesanan'

    ");


    echo "<script>

    alert('Konfirmasi pembayaran berhasil dikirim.');

    window.location='pelanggan/riwayat.php';

    </script>";

    exit;

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

Konfirmasi Pembayaran

</title>

<link rel="stylesheet"
href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

</head>

<body>

<?php include "includes/header.php"; ?>



<!-- ===========================
HEADER
=========================== -->

<section class="page-header">

<div class="container">

<h1>

<i class="fa-solid fa-money-check-dollar"></i>

Konfirmasi Pembayaran

</h1>

<p>

Silakan lakukan pembayaran sesuai total tagihan.

</p>

</div>

</section>



<div class="container">


<form

method="POST"

enctype="multipart/form-data"

class="payment-form">


<!-- ===========================
DATA PESANAN
=========================== -->

<div class="payment-left">


<div class="checkout-card">


<h2>

<i class="fa-solid fa-receipt"></i>

Informasi Pesanan

</h2>


<table class="payment-table">

<tr>

<td>ID Pesanan</td>

<td>

<strong>

#<?= $pesanan['id_pesanan']; ?>

</strong>

</td>

</tr>


<tr>

<td>Nama</td>

<td>

<?= htmlspecialchars($pesanan['nama']); ?>

</td>

</tr>


<tr>

<td>Telepon</td>

<td>

<?= htmlspecialchars($pesanan['telepon']); ?>

</td>

</tr>


<tr>

<td>Alamat</td>

<td>

<?= nl2br(htmlspecialchars($pesanan['alamat'])); ?>

</td>

</tr>


<tr>

<td>Total Bayar</td>

<td>

<strong class="total-bayar">

Rp <?= number_format($pesanan['total'],0,",","."); ?>

</strong>

</td>

</tr>

</table>

</div>




<!-- ===========================
METODE PEMBAYARAN
=========================== -->

<div class="checkout-card">

<h2>

<i class="fa-solid fa-credit-card"></i>

Metode Pembayaran

</h2>


<label>

Pilih Metode Pembayaran

</label>


<select

name="metode_pembayaran"

id="metode"

required>

<option value="">

-- Pilih Metode --

</option>

<option value="Transfer BCA">

Transfer BCA

</option>

<option value="Transfer BRI">

Transfer BRI

</option>

<option value="Transfer Mandiri">

Transfer Mandiri

</option>

<option value="Transfer BNI">

Transfer BNI

</option>

<option value="QRIS">

QRIS

</option>

<option value="COD">

Bayar di Tempat (COD)

</option>

</select>



<div

class="rekening-box"

id="rekeningBox">


Silakan pilih metode pembayaran.


</div>


</div>





<!-- ===========================
UPLOAD BUKTI
=========================== -->

<div class="checkout-card">

<h2>

<i class="fa-solid fa-upload"></i>

Upload Bukti Pembayaran

</h2>

<input

type="file"

name="bukti"

accept=".jpg,.jpeg,.png"

required>

<p>

Format:

JPG,

JPEG,

PNG

</p>

</div>


</div>





<!-- ===========================
RINGKASAN
=========================== -->

<div class="payment-right">

<div class="checkout-card">


<h2>

Ringkasan Pembayaran

</h2>


<div class="summary-item">

<span>

Status Pesanan

</span>

<strong>

<?= $pesanan['status']; ?>

</strong>

</div>


<div class="summary-item">

<span>

Total Pembayaran

</span>

<strong class="grand-total">

Rp <?= number_format($pesanan['total'],0,",","."); ?>

</strong>

</div>


<button

type="submit"

name="konfirmasi"

class="btn-checkout">

<i class="fa-solid fa-paper-plane"></i>

Kirim Konfirmasi

</button>


</div>

</div>


</form>


</div>



<?php include "includes/footer.php"; ?>



<script>

const metode=document.getElementById("metode");

const rekening=document.getElementById("rekeningBox");

metode.onchange=function(){

switch(this.value){

case "Transfer BCA":

rekening.innerHTML=

"<b>Bank BCA</b><br>1234567890<br>a.n. Erlisna Florist";

break;

case "Transfer BRI":

rekening.innerHTML=

"<b>Bank BRI</b><br>9876543210<br>a.n. Erlisna Florist";

break;

case "Transfer Mandiri":

rekening.innerHTML=

"<b>Bank Mandiri</b><br>1122334455<br>a.n. Erlisna Florist";

break;

case "Transfer BNI":

rekening.innerHTML=

"<b>Bank BNI</b><br>6677889900<br>a.n. Erlisna Florist";

break;

case "QRIS":

rekening.innerHTML=

"<b>QRIS</b><br>Silakan scan QR Code pembayaran.";

break;

case "COD":

rekening.innerHTML=

"<b>COD</b><br>Pembayaran dilakukan saat pesanan diterima.";

break;

default:

rekening.innerHTML=

"Silakan pilih metode pembayaran.";

}

}

</script>

</body>

</html>