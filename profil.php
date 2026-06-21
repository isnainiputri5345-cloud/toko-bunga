<?php
session_start();
include "config/koneksi.php";

if(!isset($_SESSION['id_pelanggan'])){

header("Location:login.php");
exit;
}

$id =
$_SESSION['id_pelanggan'];

$data = mysqli_query($koneksi,"
SELECT *
FROM pelanggan
WHERE id_pelanggan='$id'
");

$p = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Profil Saya</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include "navbar.php"; ?>

<div class="profile-box">

<h1>Profil Saya</h1>

<table>

<tr>
<td>Nama</td>
<td><?= $p['nama']; ?></td>
</tr>

<tr>
<td>Email</td>
<td><?= $p['email']; ?></td>
</tr>

<tr>
<td>Telepon</td>
<td><?= $p['telepon']; ?></td>
</tr>

<tr>
<td>Alamat</td>
<td><?= $p['alamat']; ?></td>
</tr>

</table>

</div>

</body>
</html>