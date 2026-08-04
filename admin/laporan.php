<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";


// ===============================
// FILTER TANGGAL
// ===============================

$tanggal_awal = date("Y-m-01");

$tanggal_akhir = date("Y-m-d");


if(isset($_GET['filter'])){

    $tanggal_awal = $_GET['tanggal_awal'];

    $tanggal_akhir = $_GET['tanggal_akhir'];

}



// ===============================
// TOTAL PENDAPATAN
// ===============================


$query_total = mysqli_query($koneksi,


"
SELECT SUM(total) AS total

FROM pesanan

WHERE tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'

"
);



$total_data = mysqli_fetch_assoc($query_total);


$total = $total_data['total'] ?? 0;





// ===============================
// JUMLAH TRANSAKSI
// ===============================


$query_jumlah=mysqli_query($koneksi,


"
SELECT COUNT(*) AS jumlah

FROM pesanan

WHERE tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'

"
);


$jumlah=mysqli_fetch_assoc($query_jumlah);






// ===============================
// PESANAN SELESAI
// ===============================


$query_selesai=mysqli_query($koneksi,


"
SELECT COUNT(*) AS selesai

FROM pesanan

WHERE status='Selesai'

AND tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'

"

);


$selesai=mysqli_fetch_assoc($query_selesai);






// ===============================
// DETAIL LAPORAN
// ===============================


$data=mysqli_query($koneksi,


"
SELECT

pesanan.*,

pelanggan.nama


FROM pesanan


LEFT JOIN pelanggan

ON pesanan.id_pelanggan =
pelanggan.id_pelanggan


WHERE tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'


ORDER BY id_pesanan DESC

"

);



?>



<!DOCTYPE html>

<html>

<head>


<title>
Laporan Penjualan
</title>


<link rel="stylesheet"
href="../assets/css/admin.css">


</head>



<body>



<?php include "sidebar.php"; ?>



<div class="content">



<h1>
Laporan Penjualan
</h1>





<!-- FILTER -->


<div class="laporan-box">


<h2>
Filter Laporan
</h2>


<form method="GET">


<label>
Tanggal Awal
</label>


<input type="date"
name="tanggal_awal"
value="<?= $tanggal_awal ?>">



<label>
Tanggal Akhir
</label>


<input type="date"
name="tanggal_akhir"
value="<?= $tanggal_akhir ?>">



<button name="filter">

Tampilkan

</button>


</form>


</div>







<!-- RINGKASAN -->


<div class="cards">


<div class="card">


<h2>

Rp <?= number_format(
$total,
0,
",",
"."
); ?>

</h2>


<p>
Total Pendapatan
</p>


</div>





<div class="card">


<h2>

<?= $jumlah['jumlah']; ?>

</h2>


<p>
Total Transaksi
</p>


</div>





<div class="card">


<h2>

<?= $selesai['selesai']; ?>

</h2>


<p>
Pesanan Selesai
</p>


</div>



</div>







<!-- DETAIL -->


<div class="table-box">


<h2>
Rincian Penjualan
</h2>



<table>


<tr>

<th>ID</th>

<th>Pelanggan</th>

<th>Tanggal</th>

<th>Total</th>

<th>Status</th>

</tr>





<?php


if(mysqli_num_rows($data)>0){


while($d=mysqli_fetch_assoc($data)){


?>



<tr>


<td>

#<?= $d['id_pesanan']; ?>

</td>



<td>

<?= $d['nama'] ?? 'Pelanggan'; ?>

</td>




<td>

<?= date(
"d-m-Y",
strtotime($d['tanggal'])
); ?>


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

<?= $d['status']; ?>

</td>



</tr>



<?php


}


}else{


?>

<tr>

<td colspan="5">

Belum ada data penjualan

</td>

</tr>


<?php

}


?>



</table>


</div>




</div>



</body>

</html>