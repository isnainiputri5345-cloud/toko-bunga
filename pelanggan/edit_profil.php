<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_SESSION['id_pelanggan'];

$data = mysqli_query($koneksi,"
SELECT *
FROM pelanggan
WHERE id_pelanggan='$id'
");

$p = mysqli_fetch_assoc($data);

if(isset($_POST['simpan'])){

mysqli_query($koneksi,"
UPDATE pelanggan
SET
nama='$_POST[nama]',
email='$_POST[email]',
telepon='$_POST[telepon]',
alamat='$_POST[alamat]'
WHERE id_pelanggan='$id'
");

echo "
<script>
alert('Profil Berhasil Diupdate');
window.location='profil.php';
</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profil</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

<?php include "../navbar.php"; ?>

<div class="checkout-box">

<h1>Edit Profil</h1>

<form method="POST">

<input
type="text"
name="nama"
value="<?= $p['nama']; ?>">

<input
type="email"
name="email"
value="<?= $p['email']; ?>">

<input
type="text"
name="telepon"
value="<?= $p['telepon']; ?>">

<textarea
name="alamat"><?= $p['alamat']; ?></textarea>

<button
name="simpan">

Simpan Perubahan

</button>

</form>

</div>

</body>
</html>