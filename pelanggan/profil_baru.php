<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id=$_SESSION['id_pelanggan'];

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
                $old_foto = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT foto FROM pelanggan WHERE id_pelanggan='$id'"));
                if($old_foto['foto'] && file_exists("../uploads/" . $old_foto['foto'])){
                    unlink("../uploads/" . $old_foto['foto']);
                }
                
                mysqli_query($koneksi, "UPDATE pelanggan SET foto='$new_filename' WHERE id_pelanggan='$id'");
                echo "<script>alert('Foto berhasil diupload'); window.location.reload();</script>";
            }
        } else {
            echo "<script>alert('Format file hanya JPG, JPEG, PNG, GIF');</script>";
        }
    }
}

$data=mysqli_query($koneksi,"
SELECT *
FROM pelanggan
WHERE id_pelanggan='$id'
");

$p=mysqli_fetch_assoc($data);
$foto = !empty($p['foto']) ? "../uploads/" . $p['foto'] : "../assets/images/default-profile.svg";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Saya - Erlisna Florist</title>
<link rel="stylesheet" href="../assets/css/admin.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background: #f5f5f5;
    color: #333;
}

/* Main Container */
.profile-main-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
}

/* Header Profile */
.profile-header-wrapper {
    background: white;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.profile-header-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
}

.profile-user-info {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1;
}

.profile-photo-wrapper {
    position: relative;
    width: 130px;
    height: 130px;
    flex-shrink: 0;
}

.profile-photo {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ff4fa3;
    display: block;
}

.photo-upload-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #ff4fa3;
    color: white;
    border: 3px solid white;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(255, 79, 163, 0.3);
}

.photo-upload-btn:hover {
    background: #ff2c91;
    transform: scale(1.05);
}

.profile-user-details h1 {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #222;
}

.profile-user-details p {
    font-size: 12px;
    color: #999;
    margin-bottom: 3px;
}

.profile-action-btn {
    padding: 10px 20px;
    background: #ff4fa3;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s;
    white-space: nowrap;
}

.profile-action-btn:hover {
    background: #ff2c91;
    transform: translateY(-1px);
}

/* Upload Form - Modal Style */
.upload-form {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.upload-form.active {
    display: flex;
}

.upload-modal {
    background: white;
    border-radius: 8px;
    padding: 25px;
    width: 90%;
    max-width: 480px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.upload-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f0f0;
}

.upload-modal-header h2 {
    font-size: 16px;
    font-weight: 600;
    color: #222;
}

.close-btn {
    background: none;
    border: none;
    font-size: 22px;
    color: #999;
    cursor: pointer;
    transition: color 0.3s;
}

.close-btn:hover {
    color: #333;
}

.upload-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 18px;
}

.upload-options label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 18px;
    background: #f9f9f9;
    border: 2px solid #e8e8e8;
    border-radius: 6px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    min-height: 95px;
}

.upload-options label:hover {
    border-color: #ff4fa3;
    background: #fff5f9;
}

.upload-icon {
    font-size: 26px;
    margin-bottom: 6px;
}

.upload-text {
    font-size: 12px;
    font-weight: 500;
    color: #333;
}

.upload-options input[type="file"] {
    display: none;
}

.video-container {
    display: none;
    text-align: center;
    margin: 15px 0;
}

.video-container.active {
    display: block;
}

#camera {
    width: 100%;
    max-width: 380px;
    border-radius: 6px;
    margin-bottom: 12px;
}

canvas {
    display: none;
}

.video-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.form-buttons {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
    margin-top: 18px;
}

.form-btn {
    padding: 9px 18px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.form-btn-save {
    background: #ff4fa3;
    color: white;
}

.form-btn-save:hover {
    background: #ff2c91;
}

.form-btn-cancel {
    background: #f0f0f0;
    color: #333;
    border: 1px solid #e0e0e0;
}

.form-btn-cancel:hover {
    background: #e8e8e8;
}

/* Content Section */
.profile-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.profile-section {
    background: white;
    border-radius: 8px;
    padding: 18px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.section-title {
    font-size: 14px;
    font-weight: 600;
    color: #222;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.info-item {
    margin-bottom: 14px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 12px;
    color: #999;
    font-weight: 500;
    min-width: 90px;
}

.info-value {
    font-size: 13px;
    color: #333;
    font-weight: 500;
    text-align: right;
    flex: 1;
    margin-left: 12px;
    word-break: break-word;
}

/* Action Buttons */
.action-buttons-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.btn {
    padding: 11px 18px;
    border: none;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    text-align: center;
    display: inline-block;
}

.btn-primary {
    background: #ff4fa3;
    color: white;
}

.btn-primary:hover {
    background: #ff2c91;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #f5f5f5;
    color: #333;
    border: 1px solid #e0e0e0;
}

.btn-secondary:hover {
    background: #efefef;
}

/* Responsive */
@media (max-width: 768px) {
    .profile-main-container {
        padding: 12px;
    }

    .profile-header-top {
        flex-direction: column;
        text-align: center;
    }

    .profile-user-info {
        flex-direction: column;
        width: 100%;
    }

    .profile-content {
        grid-template-columns: 1fr;
    }

    .action-buttons-section {
        grid-template-columns: 1fr;
    }

    .upload-modal {
        width: 95%;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-value {
        text-align: left;
        margin-left: 0;
        margin-top: 4px;
    }
}
</style>
</head>

<body>

<div class="profile-main-container">
    <!-- Profile Header -->
    <div class="profile-header-wrapper">
        <div class="profile-header-top">
            <div class="profile-user-info">
                <div class="profile-photo-wrapper">
                    <img src="<?= $foto; ?>" alt="Foto Profil" class="profile-photo" id="profilePhoto">
                    <button class="photo-upload-btn" onclick="toggleUploadForm()" title="Edit Foto">
                        📷
                    </button>
                </div>
                <div class="profile-user-details">
                    <h1><?= $p['nama']; ?></h1>
                    <p>Pelanggan Setia Erlisna Florist</p>
                    <p><?= $p['email']; ?></p>
                </div>
            </div>
            <a href="edit_profil.php" class="profile-action-btn">✎ Edit</a>
        </div>
    </div>

    <!-- Upload Form Modal -->
    <form method="POST" enctype="multipart/form-data" id="uploadForm" class="upload-form">
        <div class="upload-modal">
            <div class="upload-modal-header">
                <h2>📷 Update Foto</h2>
                <button type="button" class="close-btn" onclick="toggleUploadForm()">✕</button>
            </div>
            
            <div class="upload-options">
                <label for="fileInput">
                    <div class="upload-icon">📁</div>
                    <div class="upload-text">Upload File</div>
                </label>
                <label for="cameraInput">
                    <div class="upload-icon">📷</div>
                    <div class="upload-text">Ambil Foto</div>
                </label>
                <input type="file" id="fileInput" name="foto" accept="image/*">
                <input type="file" id="cameraInput" name="foto" accept="image/*" capture="environment">
            </div>

            <div class="video-container" id="videoContainer">
                <video id="camera" autoplay></video>
                <div class="video-buttons">
                    <button type="button" class="form-btn form-btn-save" id="captureBtn">✓ Ambil</button>
                    <button type="button" class="form-btn form-btn-cancel" onclick="stopCamera()">✕ Batal</button>
                </div>
                <canvas id="canvas"></canvas>
            </div>

            <div class="form-buttons">
                <button type="button" onclick="toggleUploadForm()" class="form-btn form-btn-cancel">Batal</button>
                <button type="submit" name="upload_foto" class="form-btn form-btn-save">Simpan</button>
            </div>
        </div>
    </form>

    <!-- Content Section -->
    <div class="profile-content">
        <!-- Data Pribadi -->
        <div class="profile-section">
            <div class="section-title">👤 Data Pribadi</div>
            
            <div class="info-item">
                <span class="info-label">Nama</span>
                <span class="info-value"><?= $p['nama']; ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value"><?= $p['email']; ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Telepon</span>
                <span class="info-value"><?= $p['telepon']; ?></span>
            </div>
        </div>

        <!-- Alamat -->
        <div class="profile-section">
            <div class="section-title">📍 Alamat Pengiriman</div>
            
            <div class="info-item">
                <span class="info-label">Alamat</span>
                <span class="info-value"><?= $p['alamat']; ?></span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons-section">
        <a href="edit_profil.php" class="btn btn-primary">✎ Edit Profil Lengkap</a>
        <a href="../index.php" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<script>
function toggleUploadForm(){
    var form = document.getElementById('uploadForm');
    form.classList.toggle('active');
}

document.getElementById('fileInput').addEventListener('change', function(){
    if(this.files.length > 0){
        var reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('profilePhoto').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    }
});

document.getElementById('cameraInput').addEventListener('change', function(){
    if(this.files.length > 0){
        var reader = new FileReader();
        reader.onload = function(e){
            document.getElementById('profilePhoto').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    }
});

function openCamera(){
    var videoContainer = document.getElementById('videoContainer');
    videoContainer.classList.add('active');
    
    navigator.mediaDevices.getUserMedia({video: {facingMode: 'user'}})
        .then(function(stream){
            var video = document.getElementById('camera');
            video.srcObject = stream;
            video.stream = stream;
        })
        .catch(function(err){
            alert('Tidak dapat mengakses kamera: ' + err.message);
        });
}

function stopCamera(){
    var video = document.getElementById('camera');
    if(video.stream){
        video.stream.getTracks().forEach(track => track.stop());
    }
    document.getElementById('videoContainer').classList.remove('active');
}

document.getElementById('captureBtn').addEventListener('click', function(){
    var video = document.getElementById('camera');
    var canvas = document.getElementById('canvas');
    var ctx = canvas.getContext('2d');
    
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0);
    
    var photoData = canvas.toDataURL('image/jpeg');
    document.getElementById('profilePhoto').src = photoData;
    
    canvas.toBlob(function(blob){
        var file = new File([blob], 'camera-photo.jpg', {type: 'image/jpeg'});
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        document.getElementById('fileInput').files = dataTransfer.files;
    });
    
    stopCamera();
});

document.getElementById('cameraInput').addEventListener('change', function(){
    if(this.files.length > 0){
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(this.files[0]);
        document.getElementById('fileInput').files = dataTransfer.files;
    }
});

document.querySelectorAll('.upload-options label')[1].addEventListener('click', function(e){
    if(window.innerWidth > 768){
        e.preventDefault();
        openCamera();
    }
});
</script>

</body>
</html>
