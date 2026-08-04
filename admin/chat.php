<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location:login.php");
    exit;
}

include "../config/koneksi.php";

// Balas chat
if(isset($_POST['kirim'])){

    $id    = (int)$_POST['id_pelanggan'];
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);

    if($id > 0 && $pesan != ""){

        mysqli_query($koneksi, "
        INSERT INTO chat (id_pelanggan, pengirim, pesan)
        VALUES ('$id', 'Admin', '$pesan')
        ");

        echo "<script>alert('Pesan berhasil dikirim');</script>";
    }

    echo "<script>window.location='chat.php';</script>";
    exit;
}

// Ambil daftar pelanggan yang pernah chat
$data_pelanggan = mysqli_query($koneksi, "
SELECT DISTINCT
    c.id_pelanggan,
    p.nama
FROM chat c
LEFT JOIN pelanggan p ON c.id_pelanggan = p.id_pelanggan
ORDER BY c.id_pelanggan DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Live Chat Pelanggan</title>

<link rel="stylesheet" href="../assets/css/admin.css">

<style>
.chat-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

.chat-list {
    width: 300px;
    background: white;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,.1);
}

.chat-list h3 {
    margin: 0 0 15px 0;
    color: #ff4fa3;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 10px;
}

.chat-list a {
    display: block;
    padding: 12px;
    border-radius: 8px;
    color: #333;
    text-decoration: none;
    margin-bottom: 8px;
    border: 1px solid #eee;
    font-weight: 600;
}

.chat-list a:hover,
.chat-list a.active {
    background: #fff0f6;
    border-color: #ff4fa3;
}

.chat-list a .badge-chat {
    background: #ff4fa3;
    color: white;
    border-radius: 50%;
    padding: 2px 8px;
    font-size: 12px;
    float: right;
}

.chat-window {
    flex: 1;
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 3px 10px rgba(0,0,0,.1);
}

.chat-window-header {
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
    margin-bottom: 15px;
}

.chat-window-header h3 {
    margin: 0;
    color: #333;
}

.chat-messages {
    height: 400px;
    overflow-y: auto;
    padding: 10px;
    background: #f9f9f9;
    border-radius: 10px;
    margin-bottom: 15px;
}

/* Bubble chat */
.chat-msg {
    margin-bottom: 12px;
    display: flex;
    flex-direction: column;
}

.chat-msg.pelanggan {
    align-items: flex-start;
}

.chat-msg.admin {
    align-items: flex-end;
}

.chat-msg .bubble {
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
    word-wrap: break-word;
}

.chat-msg.pelanggan .bubble {
    background: white;
    border: 1px solid #eee;
    border-top-left-radius: 0;
}

.chat-msg.admin .bubble {
    background: #ff4fa3;
    color: white;
    border-top-right-radius: 0;
}

.chat-msg .meta {
    font-size: 11px;
    color: #999;
    margin-top: 3px;
}

.chat-input {
    display: flex;
    gap: 10px;
}

.chat-input input {
    flex: 1;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: Segoe UI;
    font-size: 14px;
}

.chat-input button {
    background: #ff4fa3;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

.chat-input button:hover {
    background: #ff2c91;
}

.empty-chat {
    text-align: center;
    color: #999;
    padding: 40px;
}

.no-chat-list {
    color: #999;
    text-align: center;
    padding: 20px;
}

#chatForm {
    display: none;
}
</style>

</head>

<body>

<?php include "sidebar.php"; ?>

<div class="content">

<h1>💬 Live Chat Konsultasi Buket</h1>

<div class="chat-container">

<!-- Daftar Pelanggan -->
<div class="chat-list">
    <h3>👥 Pelanggan</h3>

    <?php
    $active_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if(mysqli_num_rows($data_pelanggan) > 0){
        while($p = mysqli_fetch_assoc($data_pelanggan)){

$nama = $p['nama'] ?? "Pelanggan #".$p['id_pelanggan'];
            $badge = '';
            $active_class = ($p['id_pelanggan'] == $active_id) ? 'active' : '';
    ?>
        <a href="chat.php?id=<?= $p['id_pelanggan']; ?>" class="<?= $active_class; ?>">
            <?= htmlspecialchars($nama); ?>
            <?= $badge; ?>
        </a>
    <?php
        }
    } else {
    ?>
        <div class="no-chat-list">Belum ada percakapan</div>
    <?php } ?>

</div>

<!-- Jendela Chat -->
<div class="chat-window">

    <?php if($active_id > 0){ ?>

    <div class="chat-window-header">
        <h3>
            💬 Chat dengan
            <?php
            $q_nama = mysqli_query($koneksi, "SELECT nama FROM pelanggan WHERE id_pelanggan='$active_id'");
            $nama_pel = mysqli_fetch_assoc($q_nama);
            echo htmlspecialchars($nama_pel['nama'] ?? "Pelanggan #$active_id");
            ?>
        </h3>
    </div>

    <div class="chat-messages" id="chatMessages">
        <!-- Isi chat akan dimuat via AJAX -->
        <div class="empty-chat">Memuat pesan...</div>
    </div>

    <form method="POST" id="chatForm">
        <input type="hidden" name="id_pelanggan" value="<?= $active_id; ?>">
        <div class="chat-input">
            <input type="text" name="pesan" placeholder="Tulis balasan..." required id="pesanInput">
            <button type="submit" name="kirim">Kirim</button>
        </div>
    </form>

    <?php } else { ?>
    <div class="empty-chat">
        <p style="font-size:48px;">👈</p>
        <p>Silakan pilih pelanggan untuk memulai percakapan</p>
    </div>
    <?php } ?>

</div>

</div>

</div>

<script>
// ============================
// AUTO-REFRESH CHAT (AJAX)
// ============================

var activeId = <?= $active_id ?: 0; ?>;
var lastPesan = "";

function loadChat(){
    if(activeId <= 0) return;

    fetch('chat_ajax.php?id_pelanggan=' + activeId)
        .then(function(res){ return res.json(); })
        .then(function(data){
            var box = document.getElementById('chatMessages');
            if(!box) return;

            var html = '';
            if(data.length === 0){
                html = '<div class="empty-chat">Belum ada pesan. Mulai percakapan!</div>';
            } else {
                data.forEach(function(c){
                    var cls = (c.pengirim === 'Admin') ? 'admin' : 'pelanggan';
                    var waktu = c.tanggal ? new Date(c.tanggal.replace(' ', 'T')).toLocaleString('id-ID') : '';
                    html += '<div class="chat-msg ' + cls + '">';
                    html += '<div class="bubble">' + c.pesan + '</div>';
                    html += '<div class="meta">' + c.pengirim + ' • ' + waktu + '</div>';
                    html += '</div>';
                });
            }

            var current = box.innerHTML;
            if(current !== html){
                box.innerHTML = html;
                box.scrollTop = box.scrollHeight;
            }
        });
}

// Jalankan saat halaman dimuat
loadChat();

// Auto-refresh setiap 2 detik
setInterval(loadChat, 2000);

// Tampilkan form chat
if(activeId > 0){
    document.getElementById('chatForm').style.display = 'block';
}
</script>

</body>

</html>
