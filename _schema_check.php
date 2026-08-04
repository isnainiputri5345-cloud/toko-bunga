<?php
include "config/koneksi.php";
$tables = ["chat", "produk", "kategori", "pesanan", "pembayaran"];
foreach($tables as $t){
    echo "=== $t ===\n";
    $q = mysqli_query($koneksi, "DESCRIBE $t");
    if(!$q){ echo "Error: ".mysqli_error($koneksi)."\n"; continue; }
    while($r = mysqli_fetch_assoc($q)){
        echo $r['Field']." | ".$r['Type']." | ".$r['Null']." | ".$r['Default']."\n";
    }
    echo "\n";
}
echo "=== CHAT COUNT ===\n";
$q = mysqli_query($koneksi, "SELECT COUNT(*) c FROM chat");
if($q){ $r = mysqli_fetch_assoc($q); echo "chat rows: ".$r['c']."\n"; }
else { echo "Error: ".mysqli_error($koneksi)."\n"; }
?>
