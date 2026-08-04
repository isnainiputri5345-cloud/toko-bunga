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
    mysqli_query($koneksi, "SELECT * FROM produk")
);

$kategori = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM kategori")
);

$pesanan = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM pesanan")
);

$pelanggan = mysqli_num_rows(
    mysqli_query($koneksi, "SELECT * FROM pelanggan")
);


// ===============================
// FILTER LAPORAN (dengan validasi)
// ===============================

$tanggal_awal = date("Y-m-01");
$tanggal_akhir = date("Y-m-d");

if(isset($_GET['filter'])){

    $tanggal_awal = $_GET['tanggal_awal'] ?? $tanggal_awal;
    $tanggal_akhir = $_GET['tanggal_akhir'] ?? $tanggal_akhir;

    // Jika salah satu kosong, kembalikan ke default
    if(trim($tanggal_awal) == ""){ $tanggal_awal = date("Y-m-01"); }
    if(trim($tanggal_akhir) == ""){ $tanggal_akhir = date("Y-m-d"); }

    // Validasi format tanggal
    $d1 = DateTime::createFromFormat('Y-m-d', $tanggal_awal);
    $d2 = DateTime::createFromFormat('Y-m-d', $tanggal_akhir);

    if(!$d1){ $tanggal_awal = date("Y-m-01"); $d1 = DateTime::createFromFormat('Y-m-d', $tanggal_awal); }
    if(!$d2){ $tanggal_akhir = date("Y-m-d"); $d2 = DateTime::createFromFormat('Y-m-d', $tanggal_akhir); }

    // Jika tanggal awal > tanggal akhir, tukar
    if($d1 && $d2 && $d1 > $d2){
        $tmp = $tanggal_awal;
        $tanggal_awal = $tanggal_akhir;
        $tanggal_akhir = $tmp;
    }
}

// Rentang penuh (jam) agar hari terakhir ikut terhitung
$tanggal_awal_full  = $tanggal_awal . " 00:00:00";
$tanggal_akhir_full = $tanggal_akhir . " 23:59:59";


// ===============================
// GRAFIK PENJUALAN (per bulan sesuai rentang)
// ===============================

// Ambil total penjualan per bulan dalam rentang filter
$query_grafik = mysqli_query($koneksi, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(total) AS total
    FROM pesanan
    WHERE tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
    ORDER BY bulan ASC
");

$grafik_data = [];
if($query_grafik){
    while($row = mysqli_fetch_assoc($query_grafik)){
        $grafik_data[$row['bulan']] = (int)($row['total'] ?? 0);
    }
}

// Nama bulan dalam Bahasa Indonesia
$nama_bulan = [
    1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
    4  => 'April',    5  => 'Mei',      6  => 'Juni',
    7  => 'Juli',     8  => 'Agustus',  9  => 'September',
    10 => 'Oktober',  11 => 'November', 12 => 'Desember'
];

// Bangun daftar bulan berurutan dari tanggal_awal s/d tanggal_akhir
$bulan  = [];
$jumlah = [];

$start = new DateTime($tanggal_awal . "-01");
$end   = new DateTime($tanggal_akhir . "-01");
$end->modify('first day of next month'); // agar bulan akhir ikut termasuk

for($d = clone $start; $d < $end; $d->modify('first day of next month')){
    $key     = $d->format('Y-m');
    $bulan[] = $nama_bulan[(int)$d->format('n')] . " " . $d->format('Y');
    $jumlah[] = $grafik_data[$key] ?? 0;
}


// ===============================
// TOTAL PENDAPATAN
// ===============================

$get_total = mysqli_query($koneksi, "
    SELECT COALESCE(SUM(total), 0) AS total
    FROM pesanan
    WHERE tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
");

$total = mysqli_fetch_assoc($get_total);
$pendapatan = $total['total'] ?? 0;


// ===============================
// TOTAL TRANSAKSI
// ===============================

$get_transaksi = mysqli_query($koneksi, "
    SELECT COUNT(*) AS jumlah
    FROM pesanan
    WHERE tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
");

$transaksi = mysqli_fetch_assoc($get_transaksi);


// ===============================
// RINGKASAN STATUS PESANAN
// ===============================

$status_list = ['Menunggu', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];
$status_count = [];

foreach($status_list as $st){
    $q = mysqli_query($koneksi, "
        SELECT COUNT(*) AS jumlah
        FROM pesanan
        WHERE status='$st'
        AND tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
    ");
    $status_count[$st] = 0;
    if($q){
        $r = mysqli_fetch_assoc($q);
        $status_count[$st] = (int)$r['jumlah'];
    }
}


// ===============================
// DETAIL PESANAN
// ===============================

$detail_pesanan = mysqli_query($koneksi, "
    SELECT
        pesanan.id_pesanan,
        pesanan.tanggal,
        pesanan.total,
        pesanan.status,
        pelanggan.nama

    FROM pesanan

    LEFT JOIN pelanggan
    ON pesanan.id_pelanggan = pelanggan.id_pelanggan

    WHERE pesanan.tanggal
    BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'

    ORDER BY pesanan.id_pesanan DESC
");

?>


<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Dashboard Admin</title>


<link rel="stylesheet" href="../assets/css/admin.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.cards-5{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:15px;
    margin-top:25px;
}
.cards-5 .card{
    padding:20px;
}
.cards-5 .card h2{
    margin:0 0 5px 0;
}
.cards-5 .card p{
    margin:0;
    color:#666;
    font-size:13px;
}
.card-status-selesai{ border-top:4px solid #28a745; }
.card-status-menunggu{ border-top:4px solid #ffc107; }
.card-status-diproses{ border-top:4px solid #17a2b8; }
.card-status-dikirim{ border-top:4px solid #007bff; }
.card-status-dibatalkan{ border-top:4px solid #dc3545; }
</style>

</head>


<body>


<?php include "sidebar.php"; ?>


<div class="content">


<h1>Dashboard Admin</h1>




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


<h2>Filter Laporan Penjualan</h2>

<p style="color:#888;margin:5px 0 15px 0;font-size:14px;">
Menampilkan periode : <?= date("d-m-Y", strtotime($tanggal_awal)); ?> s/d <?= date("d-m-Y", strtotime($tanggal_akhir)); ?>
</p>


<form method="GET">

<label>Tanggal Awal</label>

<input type="date"
name="tanggal_awal"
value="<?= $tanggal_awal ?>">


<label>Tanggal Akhir</label>

<input type="date"
name="tanggal_akhir"
value="<?= $tanggal_akhir ?>">


<button name="filter">Tampilkan</button>

<a href="dashboard.php" class="btn"
style="background:#6c757d;margin-left:10px;">Reset</a>

</form>


</div>




<!-- RINGKASAN PENDAPATAN -->

<div class="cards" style="margin-top:25px;">


<div class="card">

<h2>Rp <?= number_format($pendapatan,0,",","."); ?></h2>

<p>Total Pendapatan</p>

</div>




<div class="card">

<h2><?= $transaksi['jumlah'] ?? 0; ?></h2>

<p>Jumlah Transaksi</p>

</div>


<div class="card">

<h2><?= $status_count['Selesai']; ?></h2>

<p>Pesanan Selesai</p>

</div>


<div class="card">

<h2><?= $status_count['Dikirim']; ?></h2>

<p>Pesanan Dikirim</p>

</div>


</div>




<!-- RINGKASAN STATUS PESANAN -->

<div class="cards-5">

<div class="card card-status-menunggu">
<h2><?= $status_count['Menunggu']; ?></h2>
<p>Menunggu</p>
</div>

<div class="card card-status-diproses">
<h2><?= $status_count['Diproses']; ?></h2>
<p>Diproses</p>
</div>

<div class="card card-status-dikirim">
<h2><?= $status_count['Dikirim']; ?></h2>
<p>Dikirim</p>
</div>

<div class="card card-status-selesai">
<h2><?= $status_count['Selesai']; ?></h2>
<p>Selesai</p>
</div>

<div class="card card-status-dibatalkan">
<h2><?= $status_count['Dibatalkan']; ?></h2>
<p>Dibatalkan</p>
</div>

</div>




<!-- DETAIL PESANAN -->


<div class="table-box">


<h2>Rincian Pesanan</h2>


<table>

<tr>

<th>ID</th>

<th>Pelanggan</th>

<th>Tanggal</th>

<th>Total</th>

<th>Status</th>

</tr>


<?php

if($detail_pesanan && mysqli_num_rows($detail_pesanan) > 0){

while($row=mysqli_fetch_assoc($detail_pesanan)){


?>

<tr>


<td>#<?= $row['id_pesanan']; ?></td>


<td><?= $row['nama'] ?? 'Pelanggan'; ?></td>


<td><?= date("d-m-Y H:i", strtotime($row['tanggal'])); ?></td>


<td>Rp <?= number_format($row['total'],0,",","."); ?></td>


<td><?= $row['status']; ?></td>


</tr>


<?php

}

}else{

?>

<tr>

<td colspan="5">

Belum ada pesanan pada periode ini

</td>

</tr>

<?php

}

?>


</table>


</div>




<!-- GRAFIK -->


<div class="grafik">


<h2>Grafik Penjualan</h2>

<?php if(count($bulan) == 0){ ?>

<p style="color:#888;">Tidak ada data.</p>

<?php }else{ ?>

<canvas id="chartPenjualan"></canvas>

<?php } ?>


</div>


</div>


<script>


const ctx =
document.getElementById('chartPenjualan');

<?php if(count($bulan) > 0){ ?>

new Chart(ctx,{

type:'bar',

data:{

labels: <?= json_encode($bulan); ?>,

datasets:[{

label:'Pendapatan',

data: <?= json_encode($jumlah); ?>,

backgroundColor:'rgba(255,79,148,0.7)',
borderColor:'#ff4f94',
borderWidth:1

}]

},

options:{

responsive:true,

plugins:{
legend:{ display:false }
},

scales:{

y:{

beginAtZero:true,

ticks:{

callback:function(value){
return 'Rp ' + value.toLocaleString('id-ID');
}

}

}

}

}

});

<?php } ?>

</script>


</body>

</html>

