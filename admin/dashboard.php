<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";


// ===============================
// DATA CARD
// ===============================

$produk = mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM produk")
);


$kategori = mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM kategori")
);


$pesanan = mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM pesanan")
);


$pelanggan = mysqli_num_rows(
mysqli_query($koneksi,
"SELECT * FROM pelanggan")
);




// ===============================
// FILTER LAPORAN
// ===============================


$tanggal_awal = date("Y-m-01");

$tanggal_akhir = date("Y-m-d");


if(isset($_GET['filter'])){

    $tanggal_awal = $_GET['tanggal_awal'];

    $tanggal_akhir = $_GET['tanggal_akhir'];

}



// ===============================
// GRAFIK PENJUALAN
// ===============================


$bulan=[];

$jumlah=[];



for($i=1;$i<=12;$i++){


$query=mysqli_query($koneksi,


"
SELECT SUM(total) AS total

FROM pesanan

WHERE MONTH(tanggal)='$i'

AND tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'

"
);



if($query){

$data=mysqli_fetch_assoc($query);

$jumlah[]=$data['total'] ?? 0;


}else{

$jumlah[]=0;

}



$bulan[]=date(
"M",
mktime(0,0,0,$i,1)
);



}




// ===============================
// TOTAL PENDAPATAN
// ===============================


$get_total=mysqli_query($koneksi,


"
SELECT SUM(total) AS total

FROM pesanan

WHERE tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'

"
);



$total=mysqli_fetch_assoc($get_total);


$pendapatan=$total['total'] ?? 0;






// ===============================
// TOTAL TRANSAKSI
// ===============================


$get_transaksi=mysqli_query($koneksi,


"
SELECT COUNT(*) AS jumlah

FROM pesanan

WHERE tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'

"
);



$transaksi=mysqli_fetch_assoc($get_transaksi);





// ===============================
// DETAIL PESANAN
// ===============================


$detail_pesanan=mysqli_query($koneksi,


"
SELECT

pesanan.id_pesanan,
pesanan.tanggal,
pesanan.total,
pesanan.status,

pelanggan.nama


FROM pesanan


LEFT JOIN pelanggan

ON pesanan.id_pelanggan =
pelanggan.id_pelanggan


WHERE pesanan.tanggal

BETWEEN '$tanggal_awal'

AND '$tanggal_akhir'


ORDER BY id_pesanan DESC

"
);


?>



<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>
Dashboard Admin
</title>


<link rel="stylesheet"
href="../assets/css/admin.css">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>


<body>


<?php include "sidebar.php"; ?>



<div class="content">


<h1>
Dashboard Admin
</h1>





<!-- CARD -->


<div class="cards">


<div class="card">
<h2><?= $produk ?></h2>
<p>Produk</p>
</div>


<div class="card">
<h2><?= $kategori ?></h2>
<p>Kategori</p>
</div>


<div class="card">
<h2><?= $pesanan ?></h2>
<p>Pesanan</p>
</div>


<div class="card">
<h2><?= $pelanggan ?></h2>
<p>Pelanggan</p>
</div>


</div>







<!-- FILTER -->


<div class="laporan-box">


<h2>
Filter Laporan Penjualan
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
$pendapatan,
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

<?= $transaksi['jumlah']; ?>

</h2>


<p>
Jumlah Transaksi
</p>


</div>



</div>








<!-- DETAIL PESANAN -->


<div class="table-box">


<h2>
Rincian Pesanan
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

if(mysqli_num_rows($detail_pesanan)>0){


while($row=mysqli_fetch_assoc($detail_pesanan)){


?>


<tr>


<td>
<?= $row['id_pesanan']; ?>
</td>


<td>
<?= $row['nama'] ?? 'Pelanggan'; ?>
</td>


<td>
<?= date(
"d-m-Y",
strtotime($row['tanggal'])
); ?>
</td>


<td>

Rp <?= number_format(
$row['total'],
0,
",",
"."
); ?>

</td>


<td>

<?= $row['status']; ?>

</td>


</tr>


<?php

}


}else{


?>


<tr>

<td colspan="5">

Belum ada pesanan

</td>

</tr>


<?php

}

?>


</table>


</div>









<!-- GRAFIK -->


<div class="grafik">


<h2>
Grafik Penjualan
</h2>


<canvas id="chartPenjualan"></canvas>


</div>






</div>







<script>


const ctx =
document.getElementById('chartPenjualan');



new Chart(ctx,{


type:'bar',


data:{


labels:
<?= json_encode($bulan); ?>,


datasets:[{


label:'Pendapatan',

data:
<?= json_encode($jumlah); ?>


}]


},


options:{


responsive:true,


scales:{


y:{


beginAtZero:true


}


}


}


});


</script>



</body>

</html>