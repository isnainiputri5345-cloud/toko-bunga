<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Content-Type: application/json");
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

include "../config/koneksi.php";

$id_pelanggan = (int)$_GET['id_pelanggan'];

$data = mysqli_query($koneksi, "
SELECT * FROM chat
WHERE id_pelanggan='$id_pelanggan'
ORDER BY tanggal ASC
");

$chat = [];
while($c = mysqli_fetch_assoc($data)){
    $chat[] = [
        'pengirim' => $c['pengirim'],
        'pesan'    => $c['pesan'],
        'tanggal'  => $c['tanggal']
    ];
}

header("Content-Type: application/json");
echo json_encode($chat);
?>

