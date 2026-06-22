<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id=$_GET['id'];

$data=mysqli_query($koneksi,"
SELECT * FROM kategori
WHERE id_kategori='$id'
");

$d=mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

mysqli_query($koneksi,"
UPDATE kategori
SET nama_kategori='$_POST[nama]'
WHERE id_kategori='$id'
");

header("Location:kategori.php");
exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
    <h1>Edit Kategori</h1>
    <form method="POST" class="form-admin">
        <label>Nama Kategori</label>
        <input type="text" name="nama" value="<?= $d['nama_kategori']; ?>" required>
        <br><br>
        <button type="submit" name="update" class="btn">Update</button>
    </form>
</div>

</body>
</html>