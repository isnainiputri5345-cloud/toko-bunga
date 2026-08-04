<?php
include "config/koneksi.php";

$tanggal_awal = date("Y-m-01");
$tanggal_akhir = date("Y-m-d");
$tanggal_akhir_full = $tanggal_akhir . " 23:59:59";

echo "Tanggal Awal: $tanggal_awal\n";
echo "Tanggal Akhir: $tanggal_akhir\n\n";

// Test total pendapatan
$q = mysqli_query($koneksi, "
SELECT SUM(total) AS total
FROM pesanan
WHERE tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
");
$r = mysqli_fetch_assoc($q);
echo "Total Pendapatan: Rp " . number_format($r['total'] ?? 0,0,",",".") . "\n";

// Test jumlah transaksi
$q = mysqli_query($koneksi, "
SELECT COUNT(*) AS jumlah
FROM pesanan
WHERE tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
");
$r = mysqli_fetch_assoc($q);
echo "Jumlah Transaksi: " . $r['jumlah'] . "\n";

// Test rekap per status
$q = mysqli_query($koneksi, "
SELECT status, COUNT(*) AS jumlah, SUM(total) AS total
FROM pesanan
WHERE tanggal BETWEEN '$tanggal_awal 00:00:00' AND '$tanggal_akhir_full'
GROUP BY status
");
echo "\nRekap per Status:\n";
if($q){
    while($r = mysqli_fetch_assoc($q)){
        echo "  {$r['status']}: {$r['jumlah']} transaksi, Rp " . number_format($r['total'],0,",",".") . "\n";
    }
}

// Test apakah ada data pesanan sama sekali
$q = mysqli_query($koneksi, "SELECT COUNT(*) c FROM pesanan");
$r = mysqli_fetch_assoc($q);
echo "\nTotal semua data pesanan: " . $r['c'] . "\n";

// Test tanggal - contoh tanggal data
$q = mysqli_query($koneksi, "SELECT MIN(tanggal) mn, MAX(tanggal) mx FROM pesanan");
if($q && mysqli_num_rows($q)>0){
    $r = mysqli_fetch_assoc($q);
    echo "Rentang tanggal pesanan: {$r['mn']} - {$r['mx']}\n";
}
?>

