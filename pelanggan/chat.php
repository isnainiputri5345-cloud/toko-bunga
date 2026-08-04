<?php

session_start();

include "../config/koneksi.php";

if(!isset($_SESSION['id_pelanggan'])){
    header("Location:login.php");
    exit;
}

$id_pelanggan = $_SESSION['id_pelanggan'];

// Kirim pesan
if(isset($_POST['kirim'])){

    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);

    if($pesan != ""){

        mysqli_query($koneksi, "
        INSERT INTO chat (id_pelanggan, pengirim, pesan)
        VALUES ('$id_pelanggan', 'Pelanggan', '$pesan')
        ");

        echo "<script>window.location='chat.php';</script>";
        exit;
    }
}

// Ambil nama pelanggan
$q = mysqli_query($koneksi, "SELECT nama FROM pelanggan WHERE id_pelanggan='$id_pelanggan'");
$pelanggan = mysqli_fetch_assoc($q);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Konsultasi Buket | Erlisna Florist</title>

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>
.page-header {
    background: linear-gradient(135deg, #ff4fa3, #ff8ac2);
    color: white;
    text-align: center;
    padding: 50px 20px;
}

.page-header h1 {
    font-size: 32px;
    margin: 0 0 10px 0;
}

.page-header p {
    font-size: 16px;
    opacity: 0.9;
    margin: 0;
}

.container-chat {
    max-width: 800px;
    margin: 30px auto;
    padding: 0 20px;
}

.chat-box {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,.1);
    overflow: hidden;
}

.chat-header {
    background: #ff4fa3;
    color: white;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chat-header h3 {
    margin: 0;
    font-size: 18px;
}

.chat-header .status {
    font-size: 12px;
    background: rgba(255,255,255,.3);
    padding: 4px 10px;
    border-radius: 20px;
}

.chat-messages {
    height: 400px;
    overflow-y: auto;
    padding: 20px;
    background: #f9f9f9;
}

/* Bubble chat */
.chat-msg {
    margin-bottom: 12px;
    display: flex;
    flex-direction: column;
}

.chat-msg.pelanggan {
    align-items: flex-end;
}

.chat-msg.admin {
    align-items: flex-start;
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
    background: #ff4fa3;
    color: white;
    border-top-right-radius: 0;
}

.chat-msg.admin .bubble {
    background: white;
    border: 1px solid #eee;
    border-top-left-radius: 0;
}

.chat-msg .meta {
    font-size: 11px;
    color: #999;
    margin-top: 3px;
}

.chat-input-area {
    padding: 15px;
    background: white;
    border-top: 1px solid #eee;
}

.chat-input-area form {
    display: flex;
    gap: 10px;
}

.chat-input-area input {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-family: Segoe UI;
    font-size: 14px;
}

.chat-input-area input:focus {
    outline: none;
    border-color: #ff4fa3;
}

.chat-input-area button {
    background: #ff4fa3;
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
}

.chat-input-area button:hover {
    background: #ff2c91;
}

.empty-chat {
    text-align: center;
    color: #999;
    padding: 40px;
}
</style>

</head>

<body>

<?php include "../includes/header.php"; ?>

<section class="page-header">
    <h1>💐 Konsultasi Buket</h1>
    <p>Tanyakan buket impian Anda, kami siap membantu</p>
</section>

<div class="container-chat">

    <div class="chat-box">

        <div class="chat-header">
            <i class="fa-solid fa-headset" style="font-size:24px;"></i>
            <div>
                <h3>Erlisna Florist</h3>
                <span class="status">Online</span>
            </div>
        </div>

        <div class="chat-messages" id="chatMessages">
            <div class="empty-chat">Memuat pesan...</div>
        </div>

        <div class="chat-input-area">
            <form method="POST">
                <input type="text" name="pesan" placeholder="Tanyakan buket yang kamu inginkan..." required autocomplete="off">
                <button type="submit" name="kirim">
                    <i class="fa-solid fa-paper-plane"></i> Kirim
                </button>
            </form>
        </div>

    </div>

    <p style="text-align:center; color:#999; margin-top:20px; font-size:13px;">
        💡 Balasan dari admin biasanya datang dalam beberapa menit. Halaman akan diperbarui otomatis.
    </p>

</div>

<?php include "../includes/footer.php"; ?>

<script>
// ============================
// AUTO-REFRESH CHAT (AJAX)
// ============================

function loadChat(){
    fetch('chat_ajax.php')
        .then(function(res){ return res.json(); })
        .then(function(data){
            var box = document.getElementById('chatMessages');
            if(!box) return;

            var html = '';
            if(data.error){
                html = '<div class="empty-chat">Sesi berakhir. Silakan login kembali.</div>';
            } else if(data.length === 0){
                html = '<div class="empty-chat">Belum ada pesan. Mulai percakapan dengan admin!</div>';
            } else {
                data.forEach(function(c){
                    var cls = (c.pengirim === 'Pelanggan') ? 'pelanggan' : 'admin';
                    var waktu = c.tanggal ? new Date(c.tanggal.replace(' ', 'T')).toLocaleString('id-ID') : '';
                    var label = (c.pengirim === 'Pelanggan') ? 'Saya' : 'Admin';
                    html += '<div class="chat-msg ' + cls + '">';
                    html += '<div class="bubble">' + c.pesan + '</div>';
                    html += '<div class="meta">' + label + ' • ' + waktu + '</div>';
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
</script>

</body>

</html>
