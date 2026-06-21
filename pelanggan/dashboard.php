<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:../login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_SESSION['id_pelanggan'];

$data = mysqli_query($koneksi,"
SELECT * FROM pelanggan
WHERE id_pelanggan='$id'
");

$p = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Pelanggan</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<?php include "../navbar.php"; ?>

<div class="profile-box">

<h1>Selamat Datang</h1>

<h2><?= $p['nama']; ?></h2>

<p>Email : <?= $p['email']; ?></p>

<p>Telepon : <?= $p['telepon']; ?></p>

<p>Alamat : <?= $p['alamat']; ?></p>

<br>

<a href="riwayat.php" class="btn-primary">
Riwayat Pesanan
</a>

<a href="edit_profil.php" class="btn-secondary">
Edit Profil
</a>

</div>

</body>
</html>