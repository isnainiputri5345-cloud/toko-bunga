<?php
include "../config/koneksi.php";

if(isset($_POST['simpan'])){

mysqli_query($koneksi,"
INSERT INTO kategori(nama_kategori)
VALUES('$_POST[nama]')
");

header("Location:kategori.php");
}
?>

<form method="POST">

<input
type="text"
name="nama"
placeholder="Nama Kategori">

<button name="simpan">
Simpan
</button>

</form>