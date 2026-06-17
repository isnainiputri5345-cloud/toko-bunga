<?php
include "../config/koneksi.php";

if(isset($_POST['simpan'])){

mysqli_query($koneksi,"
INSERT INTO kategori(nama_kategori)
VALUES('$_POST[nama]')
");

header("location:kategori.php");
}
?>

<form method="POST">

<h2>Tambah Kategori</h2>

<input type="text"
name="nama"
placeholder="Nama Kategori">

<button name="simpan">
Simpan
</button>

</form>