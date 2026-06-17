<?php
include "../config/koneksi.php";

$id=$_GET['id'];

$data=mysqli_query($koneksi,"
SELECT * FROM kategori
WHERE id_kategori='$id'
");

$d=mysqli_fetch_array($data);

if(isset($_POST['update'])){

mysqli_query($koneksi,"
UPDATE kategori
SET nama_kategori='$_POST[nama]'
WHERE id_kategori='$id'
");

header("location:kategori.php");
}
?>

<form method="POST">

<input type="text"
name="nama"
value="<?= $d['nama_kategori']; ?>">

<button name="update">
Update
</button>

</form>