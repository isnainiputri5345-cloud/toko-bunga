<?php
include "config/koneksi.php";

// Simulasi filter rentang beberapa bulan
$tanggal_awal = "2026-06-01";
$tanggal_akhir = "2026-08-04";
$tanggal_awal_full  = $tanggal_awal . " 00:00:00";
$tanggal_akhir_full = $tanggal_akhir . " 23:59:59";

echo "=== TEST GRAFIK MULTI BULAN ===\n";
echo "Periode: $tanggal_awal s/d $tanggal_akhir\n\n";

// Ambil data per bulan
$grafik_data = [];
$q = mysqli_query($koneksi, "
    SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(total) AS total
    FROM pesanan
    WHERE tanggal BETWEEN '$tanggal_awal_full' AND '$tanggal_akhir_full'
    GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
    ORDER BY bulan ASC
");
while($r = mysqli_fetch_assoc($q)){
    $grafik_data[$r['bulan']] = (int)($r['total'] ?? 0);
}

$nama_bulan = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
    7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];

$bulan  = [];
$jumlah = [];
$start = new DateTime($tanggal_awal . "-01");
$end   = new DateTime($tanggal_akhir . "-01");
$end->modify('first day of next month');

for($d = clone $start; $d < $end; $d->modify('first day of next month')){
    $key     = $d->format('Y-m');
    $bulan[] = $nama_bulan[(int)$d->format('n')] . " " . $d->format('Y');
    $jumlah[] = $grafik_data[$key] ?? 0;
}

echo "Label Grafik:\n";
foreach($bulan as $i => $b){
    echo "  $b => Rp " . number_format($jumlah[$i],0,",",".") . "\n";
}

echo "\nJSON labels: " . json_encode($bulan) . "\n";
echo "JSON data: " . json_encode($jumlah) . "\n";
?>
