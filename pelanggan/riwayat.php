<?php
session_start();

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

$id=$_SESSION['id_pelanggan'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Pesanan - Erlisna Florist</title>
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

.orders-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    background: white;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-header h1 {
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

.orders-list {
    display: grid;
    gap: 20px;
}

.order-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
    border-left: 4px solid #ff4fa3;
}

.order-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.order-id {
    font-size: 16px;
    font-weight: 600;
    color: #222;
}

.order-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-processing {
    background: #cfe2ff;
    color: #084298;
}

.status-completed {
    background: #d1e7dd;
    color: #0f5132;
}

.status-cancelled {
    background: #f8d7da;
    color: #842029;
}

.order-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-label {
    font-size: 12px;
    color: #999;
    margin-bottom: 4px;
    font-weight: 600;
}

.detail-value {
    font-size: 14px;
    color: #222;
    font-weight: 600;
}

.order-actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 9px 16px;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    text-align: center;
}

.btn-primary {
    background: #ff4fa3;
    color: white;
}

.btn-primary:hover {
    background: #ff2c91;
    transform: translateY(-1px);
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

.empty-state-desc {
    color: #666;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }

    .order-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .order-details {
        grid-template-columns: 1fr;
    }
}
</style>
</head>

<body>

<body>

<div class="orders-container">
    <div class="page-header">
        <h1>📦 Riwayat Pesanan</h1>
        <a href="dashboard.php" class="back-btn">← Kembali</a>
    </div>

    <div class="orders-list">
        <?php
        $data=mysqli_query($koneksi,"
        SELECT *
        FROM pesanan
        WHERE id_pelanggan='$id'
        ORDER BY id_pesanan DESC
        ");

        if(mysqli_num_rows($data) > 0){
            while($d=mysqli_fetch_assoc($data)){
                $status_class = 'status-pending';
                if($d['status'] == 'Diproses') $status_class = 'status-processing';
                if($d['status'] == 'Selesai') $status_class = 'status-completed';
                if($d['status'] == 'Batal') $status_class = 'status-cancelled';
        ?>
            <div class="order-card">
                <div class="order-header">
                    <div class="order-id">Pesanan #<?= $d['id_pesanan']; ?></div>
                    <div class="order-status <?= $status_class; ?>"><?= $d['status']; ?></div>
                </div>
                
                <div class="order-details">
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Pesanan</span>
                        <span class="detail-value"><?= date('d/m/Y', strtotime($d['tanggal'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Total Pembayaran</span>
                        <span class="detail-value">Rp <?= number_format($d['total']); ?></span>
                    </div>
                </div>

                <div class="order-actions">
                    <a href="detail_pesanan.php?id=<?= $d['id_pesanan']; ?>" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        <?php
            }
        } else {
        ?>
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <div class="empty-state-title">Belum Ada Pesanan</div>
                <div class="empty-state-desc">Anda belum melakukan pemesanan. Mari mulai berbelanja!</div>
                <a href="../produk.php" class="btn btn-primary" style="display: inline-block; margin-top: 15px;">Belanja Sekarang</a>
            </div>
        <?php
        }
        ?>
    </div>
</div>

</body>
</html>