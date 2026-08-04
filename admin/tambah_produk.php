<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

if(isset($_POST['simpan'])){

    $nama       = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $kategori   = (int)$_POST['kategori'];
    $harga      = (int)$_POST['harga'];
    $stok       = (int)$_POST['stok'];
    $deskripsi  = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Cek gambar
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){

        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];

        if(in_array($ext, $allowed)){

            $gambar = time() . "_" . rand(1000,9999) . "." . $ext;
            move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/".$gambar);

            mysqli_query($koneksi, "
            INSERT INTO produk(
            id_kategori,
            nama_bunga,
            harga,
            stok,
            deskripsi,
            gambar
            )
            VALUES(
            '$kategori',
            '$nama',
            '$harga',
            '$stok',
            '$deskripsi',
            '$gambar'
            )
            ");

            echo "<script>alert('Produk berhasil ditambahkan'); window.location='produk.php';</script>";
            exit;

        }else{
            echo "<script>alert('Format gambar harus JPG, JPEG, PNG, GIF atau WEBP');</script>";
        }

    }else{
        echo "<script>alert('Silakan pilih gambar produk');</script>";
    }

}

// Ambil kategori untuk dropdown
$kategori_data = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Produk</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<style>
.form-admin {
    background: white;
    padding: 30px;
    border-radius: 15px;
    max-width: 700px;
    box-shadow: 0 3px 10px rgba(0,0,0,.1);
}

.form-admin label {
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-admin input,
.form-admin select,
.form-admin textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-sizing: border-box;
    font-family: Segoe UI;
    font-size: 14px;
}

.form-admin input:focus,
.form-admin select:focus,
.form-admin textarea:focus {
    outline: none;
    border-color: #ff4fa3;
    box-shadow: 0 0 5px rgba(255,79,163,.3);
}

.form-admin button {
    margin-top: 20px;
    background: #ff4fa3;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.form-admin button:hover {
    background: #ff2c91;
}

.btn-back {
    display: inline-block;
    background: #6c757d;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    margin-left: 10px;
}

.btn-back:hover {
    opacity: 0.85;
}
</style>

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

<h1>Tambah Produk</h1>

<form method="POST" enctype="multipart/form-data" class="form-admin">

<label>Nama Produk</label>
<input type="text" name="nama" placeholder="Masukkan nama produk" required>

<label>Kategori</label>
<select name="kategori" required>
<option value="">-- Pilih Kategori --</option>
<?php while($k = mysqli_fetch_assoc($kategori_data)){ ?>
<option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
<?php } ?>
</select>

<label>Harga (Rp)</label>
<input type="number" name="harga" placeholder="Masukkan harga" min="0" required>

<label>Stok</label>
<input type="number" name="stok" placeholder="Masukkan jumlah stok" min="0" required>

<label>Deskripsi</label>
<textarea name="deskripsi" rows="5" placeholder="Masukkan deskripsi produk"></textarea>

<label>Upload Gambar</label>
<input type="file" name="gambar" accept=".jpg,.jpeg,.png,.gif,.webp" required>

<button type="submit" name="simpan">💾 Simpan Produk</button>
<a href="produk.php" class="btn-back">← Kembali</a>

</form>

</div>

</body>
</html>
