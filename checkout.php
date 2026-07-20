<?php
session_start();

include "config/koneksi.php";


/* ==============================
CEK LOGIN
============================== */

if(!isset($_SESSION['id_pelanggan'])){

    header("Location: pelanggan/login.php");
    exit;

}


$id_pelanggan = $_SESSION['id_pelanggan'];



/* ==============================
DATA PELANGGAN
============================== */

$data=mysqli_query($koneksi,"
SELECT *
FROM pelanggan
WHERE id_pelanggan='$id_pelanggan'
");


$pelanggan=mysqli_fetch_assoc($data);



/* ==============================
HITUNG TOTAL
============================== */


$total=0;


$produk_checkout=[];


if(isset($_SESSION['keranjang'])){


foreach($_SESSION['keranjang'] as $id_produk=>$jumlah){



$query=mysqli_query($koneksi,"
SELECT *
FROM produk
WHERE id_produk='$id_produk'
");


$produk=mysqli_fetch_assoc($query);



if($produk){


$subtotal=$produk['harga']*$jumlah;


$total += $subtotal;



$produk_checkout[]=[

"data"=>$produk,

"jumlah"=>$jumlah,

"subtotal"=>$subtotal

];


}


}


}




/* ==============================
PROSES CHECKOUT
============================== */


if(isset($_POST['checkout'])){


$tanggal=date("Y-m-d H:i:s");



mysqli_query($koneksi,"
INSERT INTO pesanan

(
id_pelanggan,
tanggal,
total,
status

)

VALUES

(
'$id_pelanggan',
'$tanggal',
'$total',
'Menunggu'

)

");



$id_pesanan=mysqli_insert_id($koneksi);



foreach($produk_checkout as $item){



$id_produk=$item['data']['id_produk'];

$jumlah=$item['jumlah'];

$subtotal=$item['subtotal'];



mysqli_query($koneksi,"
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



unset($_SESSION['keranjang']);



header("Location: selesai.php");

exit;


}


?>



<!DOCTYPE html>

<html lang="id">


<head>


<meta charset="UTF-8">


<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
Checkout | Erlisna Florist
</title>



<link rel="stylesheet" href="assets/css/style.css">



<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">


</head>



<body>



<?php include "includes/header.php"; ?>




<section class="page-header">


<div class="container">


<h1>

<i class="fa fa-shopping-bag"></i>

Form Checkout Pesanan

</h1>


<p>

Lengkapi data pemesanan bunga Anda

</p>


</div>


</section>






<div class="checkout-container">



<form method="POST" class="checkout-form">





<!-- DATA PEMBELI -->


<div class="checkout-card">


<h2>

<i class="fa fa-user"></i>

Data Pembeli

</h2>



<label>

Nama Lengkap

</label>


<input 
type="text"
value="<?= $pelanggan['nama']; ?>"
readonly>




<label>

Nomor Telepon

</label>


<input

type="text"

value="<?= $pelanggan['telepon']; ?>"

readonly>




<label>

Alamat Pengiriman

</label>


<textarea readonly>

<?= $pelanggan['alamat']; ?>

</textarea>



</div>







<!-- DETAIL PRODUK -->


<div class="checkout-card">


<h2>

<i class="fa fa-flower"></i>

Detail Pesanan

</h2>



<?php foreach($produk_checkout as $item){ ?>


<div class="checkout-product">



<img

src="uploads/<?= $item['data']['gambar']; ?>"

>



<div>


<h4>

<?= $item['data']['nama_bunga']; ?>

</h4>



<p>

Jumlah :
<?= $item['jumlah']; ?>

</p>


<p>

Rp <?= number_format(
$item['subtotal'],
0,
",",
"."
); ?>

</p>



</div>



</div>



<?php } ?>




</div>







<!-- TOTAL -->


<div class="checkout-card total-box">


<h2>

Total Pembayaran

</h2>



<h1>

Rp <?= number_format(
$total,
0,
",",
"."
); ?>

</h1>



<button

type="submit"

name="checkout"

class="btn-checkout">


<i class="fa fa-check"></i>


Buat Pesanan


</button>



</div>





</form>



</div>






<?php include "includes/footer.php"; ?>



</body>


</html>