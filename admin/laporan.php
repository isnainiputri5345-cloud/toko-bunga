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

// Validasi tanggal dari filter
if(isset($_GET['filter'])){

    $tanggal_awal = $_GET['tanggal_awal'] ?? $tanggal_awal;
    $tanggal_akhir = $_GET['tanggal_akhir'] ?? $tanggal_akhir;

    // Validasi format tanggal
    if($tanggal_awal != "" && $tanggal_akhir != ""){
        $d1 = DateTime::createFromFormat('Y-m-d', $tanggal_awal);
        $d2 = DateTime::createFromFormat('Y-m-d', $tanggal_akhir);

        if(!$d1){ $tanggal_awal = date("Y-m-01"); }
        if(!$d2){ $tanggal_akhir = date("Y-m-d"); }

        // Jika tanggal awal > tanggal akhir, tukar
        if($d1 && $d2 && $d1 > $d2){
            $tmp = $tanggal_awal;
            $tanggal_awal = $tanggal_akhir;
            $tanggal_akhir = $tmp;
        }
    }
}

// Tambahkan jam untuk mencakup seluruh hari pada tanggal akhir
$tanggal_akhir_full = $tanggal_akhir . " 23:59:59";

// ===============================
// TOTAL PENDAPATAN (semua pesanan)
// ===============================

$query_total = mysqli_query($koneksi, "
SELECT SUM(total) AS total
FROM pesanan
WHERE tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
");

$total_data = mysqli_fetch_assoc($query_total);
$total = $total_data['total'] ?? 0;

// ===============================
// TOTAL PENDAPATAN (hanya yang sudah dibayar/selesai)
// ===============================

$query_total_lunas = mysqli_query($koneksi, "
SELECT SUM(total) AS total
FROM pesanan
WHERE status IN ('Selesai','Dikirim','Diproses')
AND tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
");

$total_lunas_data = mysqli_fetch_assoc($query_total_lunas);
$total_lunas = $total_lunas_data['total'] ?? 0;

// ===============================
// JUMLAH TRANSAKSI
// ===============================

$query_jumlah = mysqli_query($koneksi, "
SELECT COUNT(*) AS jumlah
FROM pesanan
WHERE tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
");

$jumlah = mysqli_fetch_assoc($query_jumlah);

// ===============================
// PESANAN SELESAI
// ===============================

$query_selesai = mysqli_query($koneksi, "
SELECT COUNT(*) AS selesai
FROM pesanan
WHERE status='Selesai'
AND tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
");

$selesai = mysqli_fetch_assoc($query_selesai);

// ===============================
// PESANAN MENUNGGU
// ===============================

$query_menunggu = mysqli_query($koneksi, "
SELECT COUNT(*) AS menunggu
FROM pesanan
WHERE status='Menunggu'
AND tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
");

$menunggu = mysqli_fetch_assoc($query_menunggu);

// ===============================
// DETAIL LAPORAN
// ===============================

$data = mysqli_query($koneksi, "
SELECT
pesanan.id_pesanan,
pesanan.tanggal,
pesanan.total,
pesanan.status,
pelanggan.nama
FROM pesanan
LEFT JOIN pelanggan
ON pesanan.id_pelanggan = pelanggan.id_pelanggan
WHERE pesanan.tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
ORDER BY pesanan.id_pesanan DESC
");

// ===============================
// RINGKASAN PER STATUS (untuk tabel total pendapatan)
// ===============================

$query_rekap = mysqli_query($koneksi, "
SELECT status, COUNT(*) AS jumlah, SUM(total) AS total
FROM pesanan
WHERE tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
GROUP BY status
ORDER BY status ASC
");

$rekap = [];
if($query_rekap){
    while($r = mysqli_fetch_assoc($query_rekap)){
        $rekap[] = $r;
    }
}

// =====================================
// CETAK / PDF
// =====================================
if(isset($_GET['cetak'])){
    echo "<script>window.print();</script>";
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Laporan Penjualan</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<style>
/* ====== Style Cetak / PDF ====== */
@media print {
    body * {
        visibility: hidden;
    }
    #cetakArea, #cetakArea * {
        visibility: visible;
    }
    #cetakArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 20px;
    }
    .sidebar, .no-print, .btn-cetak {
        display: none !important;
    }
    .content {
        margin-left: 0 !important;
    }
    .report-header {
        display: block !important;
    }
}

.report-header {
    display: none;
    text-align: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
}

.report-header h2 {
    margin: 0;
    font-size: 24px;
    color: #000;
}

.report-header p {
    margin: 5px 0;
    font-size: 14px;
    color: #333;
}

.btn-cetak {
    display: inline-block;
    background: #28a745;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
    margin-right: 10px;
    text-decoration: none;
}

.btn-cetak:hover {
    opacity: 0.85;
}

.laporan-actions {
    margin: 20px 0;
}

.rekap-table {
    margin-top: 20px;
}

.rekap-table th {
    background: #ff4f94;
    color: white;
    padding: 12px;
}

.rekap-table td {
    padding: 12px;
    border: 1px solid #ddd;
}

.rekap-table tr:last-child td {
    background: #fff0f6;
    font-weight: bold;
}
</style>

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content" id="cetakArea">

<h1>Laporan Penjualan</h1>

<!-- Header untuk cetak / PDF -->
<div class="report-header">
    <h2>🌸 ERLISNA FLORIST</h2>
    <p>Laporan Penjualan Periode : <?= date("d-m-Y", strtotime($tanggal_awal)); ?> s/d <?= date("d-m-Y", strtotime($tanggal_akhir)); ?></p>
    <p>Jl. Pelor Mas Raya No.III, Kekalik Jaya, Sekarbela, Mataram, NTB</p>
</div>

<!-- FILTER -->
<div class="laporan-box no-print">

<h2>Filter Laporan</h2>

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

<a href="laporan.php" class="btn" style="background:#6c757d; margin-left:10px;">Reset</a>

</form>

</div>

<!-- AKSI CETAK / PDF -->
<div class="laporan-actions no-print">

<a href="?cetak=1&tanggal_awal=<?= $tanggal_awal; ?>&tanggal_akhir=<?= $tanggal_akhir; ?>" class="btn-cetak">
    🖨️ Cetak / Download PDF
</a>

</div>

<!-- RINGKASAN -->
<div class="cards">

<div class="card">
<h2>Rp <?= number_format($total,0,",","."); ?></h2>
<p>Total Pendapatan</p>
</div>

<div class="card">
<h2>Rp <?= number_format($total_lunas,0,",","."); ?></h2>
<p>Pendapatan Lunas</p>
</div>

<div class="card">
<h2><?= $jumlah['jumlah']; ?></h2>
<p>Total Transaksi</p>
</div>

<div class="card">
<h2><?= $selesai['selesai']; ?></h2>
<p>Pesanan Selesai</p>
</div>

</div>

<!-- DETAIL -->
<div class="table-box">

<h2>Rincian Penjualan</h2>

<table>

<tr>
<th>No</th>
<th>ID</th>
<th>Pelanggan</th>
<th>Tanggal</th>
<th>Total</th>
<th>Status</th>
</tr>

<?php
$no = 1;
if(mysqli_num_rows($data)>0){
while($d=mysqli_fetch_assoc($data)){
?>

<tr>
<td><?= $no++; ?></td>
<td>#<?= $d['id_pesanan']; ?></td>
<td><?= $d['nama'] ?? 'Pelanggan'; ?></td>
<td><?= date("d-m-Y", strtotime($d['tanggal'])); ?></td>
<td>Rp <?= number_format($d['total'],0,",","."); ?></td>
<td><?= $d['status']; ?></td>
</tr>

<?php
}
}else{
?>

<tr>
<td colspan="6">Belum ada data penjualan</td>
</tr>

<?php
}
?>

</table>

</div>

<!-- TABEL TOTAL PENDAPATAN -->
<div class="table-box rekap-table">

<h2>Rekapitulasi Total Pendapatan per Status</h2>

<table>

<tr>
<th>Status</th>
<th>Jumlah Transaksi</th>
<th>Total Pendapatan</th>
</tr>

<?php
if(count($rekap)>0){
foreach($rekap as $r){
?>

<tr>
<td><?= $r['status']; ?></td>
<td><?= $r['jumlah']; ?> Transaksi</td>
<td>Rp <?= number_format($r['total'],0,",","."); ?></td>
</tr>

<?php
}
?>

<tr>
<td><strong>TOTAL</strong></td>
<td><strong><?= $jumlah['jumlah']; ?> Transaksi</strong></td>
<td><strong>Rp <?= number_format($total,0,",","."); ?></strong></td>
</tr>

<?php
}else{
?>

<tr>
<td colspan="3">Belum ada data</td>
</tr>

<?php
}
?>

</table>

</div>

</div>

</body>

</html>
