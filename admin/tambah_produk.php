<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

if(isset($_POST['simpan'])){

$gambar = $_FILES['gambar']['name'];

move_uploaded_file(
$_FILES['gambar']['tmp_name'],
"../uploads/".$gambar
);

mysqli_query($koneksi,"
INSERT INTO produk(
id_kategori,
nama_bunga,
harga,
stok,
deskripsi,
gambar
)
VALUES(
'$_POST[kategori]',
'$_POST[nama]',
'$_POST[harga]',
'$_POST[stok]',
'$_POST[deskripsi]',
'$gambar'
)
");

header("Location:produk.php");
}
?>