<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_SESSION['id_pelanggan'];

$data = mysqli_query($koneksi,"
SELECT * FROM pelanggan
WHERE id_pelanggan='$id'
");

$p = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Pelanggan - Erlisna Florist</title>
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

.dashboard-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
}

.dashboard-header {
    background: white;
    border-radius: 8px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
}

.welcome-section h1 {
    font-size: 28px;
    font-weight: 600;
    color: #222;
    margin-bottom: 8px;
}

.welcome-section p {
    font-size: 14px;
    color: #666;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.info-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    border-left: 4px solid #ff4fa3;
}

.info-card-label {
    font-size: 12px;
    color: #999;
    text-transform: uppercase;
    margin-bottom: 8px;
    font-weight: 600;
}

.info-card-value {
    font-size: 16px;
    color: #222;
    font-weight: 600;
    word-break: break-word;
}

.action-section {
    background: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.action-section h2 {
    font-size: 18px;
    font-weight: 600;
    color: #222;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.action-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}

.btn {
    padding: 14px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
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
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 79, 163, 0.3);
}

.btn-secondary {
    background: #f5f5f5;
    color: #333;
    border: 1px solid #e0e0e0;
}

.btn-secondary:hover {
    background: #efefef;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        text-align: center;
    }

    .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

<body>

<div class="dashboard-container">
    <div class="dashboard-header">
        <div class="welcome-section">
            <h1>Selamat Datang, <?= $p['nama']; ?> 👋</h1>
            <p>Kelola pesanan dan profil Anda di sini</p>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="dashboard-grid">
        <div class="info-card">
            <div class="info-card-label">📧 Email</div>
            <div class="info-card-value"><?= $p['email']; ?></div>
        </div>
        <div class="info-card">
            <div class="info-card-label">📱 Telepon</div>
            <div class="info-card-value"><?= $p['telepon']; ?></div>
        </div>
        <div class="info-card">
            <div class="info-card-label">📍 Alamat</div>
            <div class="info-card-value"><?= $p['alamat']; ?></div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <h2>Navigasi Cepat</h2>
        <div class="action-buttons">
            <a href="riwayat.php" class="btn btn-primary">📦 Riwayat Pesanan</a>
            <a href="edit_profil.php" class="btn btn-secondary">✎ Edit Profil</a>
            <a href="../index.php" class="btn btn-secondary">← Kembali</a>
        </div>
    </div>
</div>

</body>
</html>