<?php
include "config/koneksi.php";

// ===== Simulasi filter default (bulan ini) =====
$tanggal_awal = date("Y-m-01");
$tanggal_akhir = date("Y-m-d");
$tanggal_awal_full  = $tanggal_awal . " 00:00:00";
$tanggal_akhir_full = $tanggal_akhir . " 23:59:59";

echo "=== TEST DASHBOARD ===\n";
echo "Periode: $tanggal_awal s/d $tanggal_akhir\n\n";

// Grafik per bulan
$q = mysqli_query($koneksi, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(total) AS total
    FROM pesanan
    WHERE tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
    ORDER BY bulan ASC
");
echo "Data grafik per bulan:\n";
while($r = mysqli_fetch_assoc($q)){
    echo "  {$r['bulan']}: Rp " . number_format($r['total'] ?? 0,0,",",".") . "\n";
}

// Total pendapatan
$q = mysqli_query($koneksi, "
    SELECT COALESCE(SUM(total),0) AS total
    FROM pesanan
    WHERE tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
");
$r = mysqli_fetch_assoc($q);
echo "\nTotal Pendapatan: Rp " . number_format($r['total'] ?? 0,0,",",".") . "\n";

// Jumlah transaksi
$q = mysqli_query($koneksi, "
    SELECT COUNT(*) AS jumlah
    FROM pesanan
    WHERE tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
");
$r = mysqli_fetch_assoc($q);
echo "Jumlah Transaksi: " . $r['jumlah'] . "\n";

// Ringkasan status
echo "\nRingkasan Status:\n";
foreach(['Menunggu','Diproses','Dikirim','Selesai','Dibatalkan'] as $st){
    $qsq = mysqli_query($koneksi, "
        SELECT COUNT(*) AS jumlah
        FROM pesanan
        WHERE status='$st'
        AND tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
    ");
    $rsq = mysqli_fetch_assoc($qsq);
    echo "  $st: " . $rsq['jumlah'] . "\n";
}

// Detail pesanan
$q = mysqli_query($koneksi, "
    SELECT pesanan.id_pesanan, pesanan.tanggal, pesanan.total, pesanan.status, pelanggan.nama
    FROM pesanan
    LEFT JOIN pelanggan ON pesanan.id_pelanggan = pelanggan.id_pelanggan
    WHERE pesanan.tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
    ORDER BY pesanan.id_pesanan DESC
");
echo "\nDetail Pesanan (periode ini):\n";
while($r = mysqli_fetch_assoc($q)){
    echo "  #{$r['id_pesanan']} | {$r['nama']} | {$r['tanggal']} | Rp " . number_format($r['total'],0,",",".") . " | {$r['status']}\n";
}
?>
