<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($koneksi,"
SELECT * FROM produk
WHERE id_produk='$id'
");

$produk = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $nama       = $_POST['nama'];
    $kategori   = $_POST['kategori'];
    $harga      = $_POST['harga'];
    $stok       = $_POST['stok'];
    $deskripsi  = $_POST['deskripsi'];

    /* jika upload gambar baru */
    if($_FILES['gambar']['name'] != ''){

        $gambar = $_FILES['gambar']['name'];
        $tmp    = $_FILES['gambar']['tmp_name'];

        /* hapus gambar lama */
        if(file_exists("../uploads/".$produk['gambar'])){
            unlink("../uploads/".$produk['gambar']);
        }

        move_uploaded_file(
            $tmp,
            "../uploads/".$gambar
        );

        mysqli_query($koneksi,"
        UPDATE produk SET
        id_kategori='$kategori',
        nama_bunga='$nama',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi',
        gambar='$gambar'
        WHERE id_produk='$id'
        ");

    }else{

        mysqli_query($koneksi,"
        UPDATE produk SET
        id_kategori='$kategori',
        nama_bunga='$nama',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi'
        WHERE id_produk='$id'
        ");

    }

    echo "
    <script>
    alert('Produk berhasil diupdate');
    window.location='produk.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Produk</title>

<link rel="stylesheet"
href="../assets/css/admin.css">

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Edit Produk</h1>

<form method="POST"
enctype="multipart/form-data"
class="form-admin">

<label>Nama Produk</label>

<input
type="text"
name="nama"
value="<?= $produk['nama_bunga']; ?>"
required>

<label>Kategori</label>

<select name="kategori" required>

<?php

$kat = mysqli_query($koneksi,"
SELECT * FROM kategori
");

while($k = mysqli_fetch_assoc($kat)){

    $selected = "";

    if($k['id_kategori'] ==
       $produk['id_kategori']){

        $selected = "selected";
    }

?>

<option
value="<?= $k['id_kategori']; ?>"
<?= $selected; ?>>

<?= $k['nama_kategori']; ?>

</option>

<?php } ?>

</select>

<label>Harga</label>

<input
type="number"
name="harga"
value="<?= $produk['harga']; ?>"
required>

<label>Stok</label>

<input
type="number"
name="stok"
value="<?= $produk['stok']; ?>"
required>

<label>Deskripsi</label>

<textarea
name="deskripsi"
rows="5"><?= $produk['deskripsi']; ?></textarea>

<label>Gambar Saat Ini</label>

<br><br>

<img
src="../uploads/<?= $produk['gambar']; ?>"
width="150">

<br><br>

<label>Upload Gambar Baru</label>

<input
type="file"
name="gambar">

<br><br>

<button
type="submit"
name="update"
class="btn">

Update Produk

</button>

</form>

</div>

</body>
</html>