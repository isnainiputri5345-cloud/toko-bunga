<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id=$_GET['id'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Pesanan - Erlisna Florist</title>
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

.detail-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.detail-header {
    background: white;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-header h1 {
    font-size: 28px;
    font-weight: 600;
    color: #222;
}

.back-btn {
    padding: 10px 20px;
    background: #f5f5f5;
    color: #333;
    border: 1px solid #e0e0e0;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.back-btn:hover {
    background: #efefef;
}

.items-section {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
}

.section-title {
    padding: 20px;
    background: #f9f9f9;
    border-bottom: 2px solid #f0f0f0;
    font-size: 16px;
    font-weight: 600;
    color: #222;
}

.items-table {
    width: 100%;
    border-collapse: collapse;
}

.items-table thead {
    background: #f5f5f5;
    border-bottom: 1px solid #e0e0e0;
}

.items-table th {
    padding: 15px;
    text-align: left;
    font-size: 12px;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.items-table td {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    font-size: 14px;
}

.items-table tbody tr:last-child td {
    border-bottom: none;
}

.item-name {
    font-weight: 600;
    color: #222;
}

.item-price {
    color: #ff4fa3;
    font-weight: 600;
}

.summary-section {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.summary-row:last-child {
    border-bottom: none;
}

.summary-label {
    color: #666;
    font-size: 14px;
}

.summary-value {
    font-weight: 600;
    color: #222;
    font-size: 14px;
}

.summary-total {
    font-size: 18px;
}

.summary-total .summary-value {
    color: #ff4fa3;
    font-size: 18px;
}

.action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    text-align: center;
}

.btn-secondary {
    background: #f5f5f5;
    color: #333;
    border: 1px solid #e0e0e0;
}

.btn-secondary:hover {
    background: #efefef;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.empty-state-icon {
    font-size: 48px;
    margin-bottom: 15px;
}

.empty-state-title {
    font-size: 18px;
    font-weight: 600;
    color: #222;
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .detail-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .items-table {
        font-size: 12px;
    }

    .items-table th,
    .items-table td {
        padding: 10px;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>
</head>

<body>

<body>

<div class="detail-container">
    <div class="detail-header">
        <h1>📋 Detail Pesanan</h1>
        <a href="riwayat.php" class="back-btn">← Kembali</a>
    </div>

    <?php
    $id_pesanan = $_GET['id'];
    
    // Validasi ID pesanan
    if(!isset($id_pesanan) || empty($id_pesanan)){
        echo "<div class='empty-state'>";
        echo "<div class='empty-state-icon'>⚠️</div>";
        echo "<div class='empty-state-title'>Data Tidak Valid</div>";
        echo "</div>";
        exit;
    }

    // Ambil data pesanan
    $pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan' AND id_pelanggan='$id'");
    if(mysqli_num_rows($pesanan) == 0){
        echo "<div class='empty-state'>";
        echo "<div class='empty-state-icon'>🔍</div>";
        echo "<div class='empty-state-title'>Pesanan Tidak Ditemukan</div>";
        echo "</div>";
        exit;
    }

    $p = mysqli_fetch_assoc($pesanan);
    ?>

    <!-- Items Table -->
    <div class="items-section">
        <div class="section-title">📦 Daftar Produk</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data=mysqli_query($koneksi,"
                SELECT *
                FROM detail_pesanan
                JOIN produk
                ON detail_pesanan.id_produk = produk.id_produk
                WHERE id_pesanan='$id_pesanan'
                ");

                while($d=mysqli_fetch_assoc($data)){
                ?>
                <tr>
                    <td class="item-name"><?= $d['nama_bunga']; ?></td>
                    <td class="item-price">Rp <?= number_format($d['harga']); ?></td>
                    <td><?= $d['jumlah']; ?></td>
                    <td class="item-price">Rp <?= number_format($d['subtotal']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-row">
            <span class="summary-label">Status Pesanan</span>
            <span class="summary-value"><?= $p['status']; ?></span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Tanggal Pesanan</span>
            <span class="summary-value"><?= date('d/m/Y H:i', strtotime($p['tanggal'])); ?></span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Alamat Pengiriman</span>
            <span class="summary-value"><?= $p['alamat_pengiriman']; ?></span>
        </div>
        <div class="summary-row summary-total">
            <span class="summary-label">Total Pembayaran</span>
            <span class="summary-value">Rp <?= number_format($p['total']); ?></span>
        </div>

        <div class="action-buttons">
            <a href="riwayat.php" class="btn btn-secondary">← Kembali ke Riwayat</a>
        </div>
    </div>
</div>

</body>
</html>