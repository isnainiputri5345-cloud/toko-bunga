<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}


include "../config/koneksi.php";


// UPDATE STATUS PEMBAYARAN

if(isset($_POST['update'])){


$id_pembayaran=$_POST['id_pembayaran'];

$status=$_POST['status_pembayaran'];



mysqli_query($koneksi,


"
UPDATE pembayaran

SET status_pembayaran='$status'

WHERE id_pembayaran='$id_pembayaran'

"


);



echo "

<script>

alert('Status pembayaran berhasil diperbarui');

window.location='pembayaran.php';

</script>

";


}


?>


<!DOCTYPE html>

<html>


<head>

<title>
Data Pembayaran
</title>


<link rel="stylesheet"
href="../assets/css/admin.css">


</head>


<body>


<?php include "sidebar.php"; ?>



<div class="content">


<h1>
Data Pembayaran
</h1>




<table>


<tr>

<th>ID</th>

<th>Pelanggan</th>

<th>Total</th>

<th>Tanggal</th>

<th>Bukti</th>

<th>Status</th>

<th>Aksi</th>

</tr>



<?php


$data=mysqli_query($koneksi,


"

SELECT

pembayaran.*,

pesanan.total,

pesanan.id_pesanan,

pelanggan.nama


FROM pembayaran


JOIN pesanan

ON pembayaran.id_pesanan =
pesanan.id_pesanan


JOIN pelanggan

ON pesanan.id_pelanggan =
pelanggan.id_pelanggan


ORDER BY id_pembayaran DESC


"


);



while($d=mysqli_fetch_assoc($data)){


?>



<tr>


<td>

<?= $d['id_pembayaran']; ?>

</td>



<td>

<?= $d['nama']; ?>

</td>




<td>

Rp <?= number_format(
$d['total'],
0,
",",
"."
); ?>

</td>




<td>

<?= $d['tanggal_bayar']; ?>

</td>




<td>


<?php if($d['bukti_pembayaran']){ ?>


<a href="../uploads/bukti/<?= $d['bukti_pembayaran']; ?>"
target="_blank">

Lihat Bukti

</a>


<?php }else{ ?>

Belum Upload

<?php } ?>


</td>




<td>


<form method="POST">


<input type="hidden"
name="id_pembayaran"
value="<?= $d['id_pembayaran']; ?>">



<select name="status_pembayaran">


<option value="Menunggu"

<?= $d['status_pembayaran']=="Menunggu"?'selected':''; ?>

>

Menunggu

</option>



<option value="Diterima"

<?= $d['status_pembayaran']=="Diterima"?'selected':''; ?>

>

Diterima

</option>




<option value="Ditolak"

<?= $d['status_pembayaran']=="Ditolak"?'selected':''; ?>

>

Ditolak

</option>


</select>


</td>



<td>


<button name="update">

Update

</button>


</form>


</td>


</tr>



<?php } ?>



</table>



</div>


</body>


</html>