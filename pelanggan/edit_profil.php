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

if(!$data){
    die("Query Error: " . mysqli_error($koneksi));
}

$p = mysqli_fetch_assoc($data);

// Proses upload foto
if(isset($_POST['upload_foto'])){
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_name = $_FILES['foto']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Validasi tipe file
        $allowed = array('jpg', 'jpeg', 'png', 'gif');
        if(in_array($file_ext, $allowed)){
            // Buat nama file unik
            $new_filename = "profil_" . $id . "_" . time() . "." . $file_ext;
            $upload_path = "../uploads/" . $new_filename;
            
            if(move_uploaded_file($file_tmp, $upload_path)){
                // Hapus foto lama jika ada
                $query_old = mysqli_query($koneksi, "SELECT foto FROM pelanggan WHERE id_pelanggan='$id'");
                if($query_old){
                    $old_foto = mysqli_fetch_assoc($query_old);
                    if($old_foto && $old_foto['foto'] && file_exists("../uploads/" . $old_foto['foto'])){
                        unlink("../uploads/" . $old_foto['foto']);
                    }
                }
                
                mysqli_query($koneksi, "UPDATE pelanggan SET foto='$new_filename' WHERE id_pelanggan='$id'");
                echo "<script>alert('Foto berhasil diupload'); window.location.reload();</script>";
            }
        } else {
            echo "<script>alert('Format file hanya JPG, JPEG, PNG, GIF');</script>";
        }
    }
}

// Proses update data profil
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

    echo "<script>
    alert('Profil Berhasil Diupdate');
    window.location='profil.php';
    </script>";
}

// Ambil data terbaru
$data = mysqli_query($koneksi,"
SELECT *
FROM pelanggan
WHERE id_pelanggan='$id'
");

if(!$data){
    die("Query Error: " . mysqli_error($koneksi));
}

$p = mysqli_fetch_assoc($data);
$foto = !empty($p['foto']) ? "../uploads/" . $p['foto'] : "../assets/images/default-profile.svg";
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profil</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<style>
body {
    background: #f5f6fa;
}

.edit-profile-container {
    max-width: 700px;
    margin: 30px auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,.1);
}

.edit-header {
    text-align: center;
    margin-bottom: 30px;
}

.edit-header h1 {
    color: #ff4fa3;
    margin: 0;
    font-size: 28px;
}

.edit-header p {
    color: #666;
    margin-top: 5px;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h3 {
    color: #ff4fa3;
    border-bottom: 2px solid #ff4fa3;
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-size: 16px;
}

.photo-section {
    text-align: center;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 10px;
    margin-bottom: 20px;
}

.profile-photo-edit {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #ff4fa3;
    display: inline-block;
    margin-bottom: 20px;
}

.photo-info {
    color: #666;
    font-size: 13px;
    margin-bottom: 15px;
}

.file-input-wrapper {
    position: relative;
    display: inline-block;
}

.file-input-label {
    display: inline-block;
    background: #ff4fa3;
    color: white;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
    font-size: 14px;
    font-weight: bold;
}

.file-input-label:hover {
    background: #ff2c91;
}

.file-input-wrapper input[type="file"] {
    display: none;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #ff4fa3;
    font-weight: bold;
    font-size: 14px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: Segoe UI;
    font-size: 14px;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #ff4fa3;
    box-shadow: 0 0 5px rgba(255, 79, 163, 0.3);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.form-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-top: 30px;
}

.btn-primary {
    background: #ff4fa3;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background 0.3s;
}

.btn-primary:hover {
    background: #ff2c91;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    text-align: center;
    transition: background 0.3s;
}

.btn-secondary:hover {
    background: #5a6268;
}

.upload-status {
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    text-align: center;
    font-size: 13px;
}

.upload-status.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.upload-status.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
</head>

<body>

<?php include "../navbar.php"; ?>

<div class="edit-profile-container">
    <div class="edit-header">
        <h1>Edit Profil Pelanggan</h1>
        <p>Perbarui informasi profil dan foto Anda</p>
    </div>

    <!-- Section Foto Profil -->
    <div class="form-section">
        <h3>📷 Foto Profil</h3>
        <div class="photo-section">
            <img src="<?= $foto; ?>" alt="Foto Profil" class="profile-photo-edit" id="previewFoto">
            <div class="photo-info">
                Format: JPG, JPEG, PNG, GIF<br>
                Ukuran maksimal: 5 MB
            </div>
            <form method="POST" enctype="multipart/form-data" id="fotoForm">
                <div class="file-input-wrapper">
                    <label for="fotoInput" class="file-input-label">
                        Pilih Foto
                    </label>
                    <input type="file" id="fotoInput" name="foto" accept="image/*" onchange="handleFotoChange(this)">
                </div>
                <button type="submit" name="upload_foto" class="file-input-label" style="margin-left: 10px;">
                    Upload Foto
                </button>
            </form>
        </div>
    </div>

    <!-- Section Data Profil -->
    <form method="POST">
        <div class="form-section">
            <h3>👤 Data Diri</h3>
            
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?= $p['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $p['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="telepon">Nomor Telepon</label>
                <input type="text" id="telepon" name="telepon" value="<?= $p['telepon']; ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" required><?= $p['alamat']; ?></textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" name="simpan" class="btn-primary">
                💾 Simpan Perubahan
            </button>
            <a href="profil.php" class="btn-secondary">
                ❌ Batal
            </a>
        </div>
    </form>
</div>

<script>
function handleFotoChange(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewFoto').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-submit form foto ketika file dipilih (optional)
document.getElementById('fotoForm').addEventListener('submit', function(e) {
    // Biarkan form submit normal
});
</script>

</body>
</html>