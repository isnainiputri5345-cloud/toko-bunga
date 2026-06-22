<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

if(isset($_POST['simpan'])){

mysqli_query($koneksi,"
INSERT INTO kategori(nama_kategori)
VALUES('$_POST[nama]')
");

header("Location:kategori.php");
exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h1>Tambah Kategori</h1>
    <form method="POST" class="form-admin">
        <label>Nama Kategori</label>
        <input type="text" name="nama" placeholder="Nama Kategori" required>
        <br><br>
        <button type="submit" name="simpan" class="btn">Simpan</button>
    </form>
</div>

</body>
</html>