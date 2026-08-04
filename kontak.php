<?php
session_start();
include "config/koneksi.php";

/* =========================================
   PROSES KIRIM PESAN
========================================= */
$pesan_terkirim = false;
if(isset($_POST['kirim_pesan'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telepon = mysqli_real_escape_string($koneksi, $_POST['telepon']);
    $subjek = mysqli_real_escape_string($koneksi, $_POST['subjek']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);

    mysqli_query($koneksi, "
        INSERT INTO pesan (nama, email, telepon, subjek, pesan)
        VALUES ('$nama', '$email', '$telepon', '$subjek', '$pesan')
    ");
    $pesan_terkirim = true;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kontak Kami | Erlisna Florist</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>

        /* ==========================
           HERO KONTAK
        ========================== */

        .contact-hero{
            background:linear-gradient(135deg,#fff6fa,#ffe4ef);
            padding:90px 0;
            overflow:hidden;
        }

        .contact-hero-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            align-items:center;
            gap:60px;
        }

        .contact-hero .tag{
            display:inline-block;
            background:#fff;
            color:var(--primary);
            padding:9px 22px;
            border-radius:30px;
            font-weight:600;
            font-size:14px;
            box-shadow:0 6px 15px rgba(0,0,0,.06);
            margin-bottom:20px;
        }

        .contact-hero h1{
            font-size:46px;
            line-height:1.2;
            color:var(--primary);
            margin-bottom:20px;
            font-weight:700;
        }

        .contact-hero p{
            font-size:17px;
            color:#666;
            line-height:1.8;
            margin-bottom:32px;
        }

        .contact-hero .hero-btns{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        .btn-secondary{
            display:inline-block;
            border:2px solid var(--primary);
            color:var(--primary);
            padding:14px 32px;
            border-radius:35px;
            font-weight:600;
            transition:var(--transition);
        }

        .btn-secondary:hover{
            background:var(--primary);
            color:#fff;
        }

        .btn-wa{
            display:inline-block;
            background:#25d366;
            color:#fff;
            padding:14px 32px;
            border-radius:35px;
            font-weight:600;
            transition:var(--transition);
        }

        .btn-wa:hover{
            background:#1ebe5b;
            transform:translateY(-3px);
            box-shadow:0 10px 25px rgba(37,211,102,.3);
        }

        .contact-hero-img{
            text-align:center;
        }

        .contact-hero-img img{
            width:100%;
            max-width:480px;
            border-radius:25px;
            box-shadow:0 18px 40px rgba(0,0,0,.12);
        }

        /* ==========================
           INFO KONTAK
        ========================== */

        .info-section{
            padding:90px 0;
            background:#fff;
        }

        .contact-cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:25px;
            margin-top:40px;
        }

        .contact-card{
            background:#fff7fb;
            border-radius:18px;
            padding:35px 25px;
            text-align:center;
            border:1px solid #ffe3ef;
            transition:.3s;
        }

        .contact-card:hover{
            transform:translateY(-8px);
            box-shadow:0 12px 28px rgba(0,0,0,.10);
        }

        .contact-card .icon{
            width:70px;
            height:70px;
            background:var(--primary);
            color:#fff;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:26px;
            margin:0 auto 18px;
        }

        .contact-card h3{
            font-size:20px;
            color:#333;
            margin-bottom:10px;
        }

        .contact-card p{
            color:#777;
            line-height:1.8;
            font-size:15px;
            margin-bottom:15px;
        }

        .contact-card .mini-btn{
            display:inline-block;
            background:var(--primary);
            color:#fff;
            padding:10px 22px;
            border-radius:30px;
            font-size:14px;
            font-weight:600;
            transition:.3s;
        }

        .contact-card .mini-btn:hover{
            background:var(--primary-dark);
            transform:translateY(-2px);
        }

        /* ==========================
           FORM & MAP
        ========================== */

        .form-section{
            padding:90px 0;
            background:#fff7fb;
        }

        .contact-wrapper{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:40px;
            align-items:stretch;
        }

        .contact-form-box{
            background:#fff;
            border-radius:20px;
            padding:35px;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }

        .contact-form-box h2{
            color:var(--primary);
            font-size:28px;
            margin-bottom:25px;
        }

        .input-group{
            margin-bottom:18px;
        }

        .input-group label{
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#555;
        }

        .input-group label i{
            color:var(--primary);
            margin-right:6px;
        }

        .input-group input,
        .input-group textarea{
            width:100%;
            padding:14px 16px;
            border:1px solid #ddd;
            border-radius:10px;
            outline:none;
            font-size:15px;
            transition:.3s;
            font-family:'Poppins',sans-serif;
        }

        .input-group input:focus,
        .input-group textarea:focus{
            border-color:var(--primary);
            box-shadow:0 0 8px rgba(255,79,148,.15);
        }

        .input-group textarea{
            resize:vertical;
            min-height:120px;
        }

        .form-alert{
            background:#e9fff2;
            color:#198754;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
            text-align:center;
            font-weight:600;
        }

        .contact-map{
            background:#fff;
            border-radius:20px;
            padding:35px;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }

        .contact-map h2{
            color:var(--primary);
            font-size:28px;
            margin-bottom:25px;
        }

        .map-box{
            border-radius:15px;
            overflow:hidden;
            margin-bottom:25px;
        }

        .map-box iframe{
            width:100%;
            height:280px;
            border:0;
            display:block;
        }

        .location-detail{
            display:flex;
            flex-direction:column;
            gap:15px;
        }

        .location-item{
            display:flex;
            align-items:flex-start;
            gap:15px;
        }

        .location-item i{
            width:42px;
            height:42px;
            background:#ffe4ef;
            color:var(--primary);
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:17px;
            flex-shrink:0;
        }

        .location-item h4{
            color:#333;
            margin-bottom:4px;
        }

        .location-item p{
            color:#777;
            font-size:14px;
            line-height:1.7;
        }

        /* ==========================
           RESPONSIVE
        ========================== */

        @media(max-width:992px){
            .contact-hero-grid,
            .contact-wrapper{
                grid-template-columns:1fr;
            }
            .contact-hero{
                text-align:center;
            }
            .contact-hero .hero-btns{
                justify-content:center;
            }
            .contact-hero-img img{
                max-width:340px;
            }
        }

        @media(max-width:600px){
            .contact-hero h1{
                font-size:34px;
            }
            .contact-form-box,
            .contact-map{
                padding:25px;
            }
        }

    </style>

</head>

<body>

<?php include "includes/header.php"; ?>

<!-- ================= HERO ================= -->
<section class="contact-hero">
    <div class="container contact-hero-grid">
        <div class="contact-hero-content">
            <span class="tag">🌸 Hubungi Kami</span>
            <h1>Kami Siap Membantu Mewujudkan Momen Spesial Anda</h1>
            <p>
                Apabila Anda memiliki pertanyaan mengenai produk, proses pemesanan,
                pengiriman, ataupun ingin membuat bouquet custom, silakan hubungi kami
                melalui kontak yang tersedia. Tim Erlisna Florist siap melayani Anda
                dengan ramah dan cepat.
            </p>
            <div class="hero-btns">
                <a href="produk.php" class="btn-primary">
                    <i class="fa-solid fa-gift"></i> Lihat Produk
                </a>
                <a href="https://wa.me/6281946716865" target="_blank" class="btn-wa">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
        <div class="contact-hero-img">
            <img src="assets/images/buket a1.jpg" alt="Erlisna Florist">
        </div>
    </div>
</section>

<!-- ================= INFORMASI KONTAK ================= -->
<section class="info-section">
    <div class="container">
        <div class="section-title">
            <span>🌸 Erlisna Florist</span>
            <h2>Informasi Kontak</h2>
            <p>Silakan hubungi kami melalui salah satu media berikut. Kami siap membantu Anda setiap hari.</p>
        </div>

        <div class="contact-cards">
            <div class="contact-card">
                <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                <h3>Alamat</h3>
                <p>
                    Jl. Pelor Mas Raya No.III, Kekalik Jaya,<br>
                    Kec. Sekarbela, Kota Mataram,<br>
                    Nusa Tenggara Barat 83126
                </p>
                <a href="https://maps.google.com/?q=Mataram+NTB" target="_blank" class="mini-btn">
                    Lihat Lokasi
                </a>
            </div>

            <div class="contact-card">
                <div class="icon"><i class="fab fa-whatsapp"></i></div>
                <h3>WhatsApp</h3>
                <p>0819-4671-6865</p>
                <a href="https://wa.me/6281946716865" target="_blank" class="mini-btn">
                    Chat Sekarang
                </a>
            </div>

            <div class="contact-card">
                <div class="icon"><i class="fa-solid fa-envelope"></i></div>
                <h3>Email</h3>
                <p>erlisnaflorist@gmail.com</p>
                <a href="mailto:erlisnaflorist@gmail.com" class="mini-btn">
                    Kirim Email
                </a>
            </div>

            <div class="contact-card">
                <div class="icon"><i class="fa-solid fa-clock"></i></div>
                <h3>Jam Operasional</h3>
                <p>Senin - Minggu<br>08.00 - 21.00 WITA</p>
                <a href="produk.php" class="mini-btn">
                    Lihat Produk
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ================= FORM & MAP ================= -->
<section class="form-section">
    <div class="container">
        <div class="contact-wrapper">

            <!-- FORM -->
            <div class="contact-form-box">
                <h2>Kirim Pesan</h2>
                <p style="color:#777;margin-bottom:25px;line-height:1.8;">
                    Silakan isi formulir di bawah ini apabila Anda memiliki pertanyaan,
                    kritik, saran, ataupun ingin melakukan pemesanan bouquet custom.
                </p>

                <?php if($pesan_terkirim){ ?>
                    <div class="form-alert">
                        <i class="fa-solid fa-circle-check"></i>
                        Terima kasih! Pesan Anda telah kami terima dan akan segera kami balas.
                    </div>
                <?php } ?>

                <form method="POST" action="">
                    <div class="input-group">
                        <label><i class="fa-solid fa-user"></i> Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                    </div>
                    <div class="input-group">
                        <label><i class="fa-solid fa-envelope"></i> Email</label>
                        <input type="email" name="email" placeholder="Masukkan email aktif" required>
                    </div>
                    <div class="input-group">
                        <label><i class="fa-brands fa-whatsapp"></i> Nomor WhatsApp</label>
                        <input type="text" name="telepon" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="input-group">
                        <label><i class="fa-solid fa-tag"></i> Subjek</label>
                        <input type="text" name="subjek" placeholder="Contoh: Pemesanan Bouquet Wisuda">
                    </div>
                    <div class="input-group">
                        <label><i class="fa-solid fa-comment-dots"></i> Pesan</label>
                        <textarea name="pesan" rows="6" placeholder="Tuliskan pesan Anda..." required></textarea>
                    </div>
                    <button type="submit" name="kirim_pesan" class="btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- MAP -->
            <div class="contact-map">
                <h2>Kunjungi Toko Kami</h2>
                <p style="color:#777;margin-bottom:25px;line-height:1.8;">
                    Datang langsung ke toko Erlisna Florist untuk melihat koleksi
                    bouquet terbaik, berkonsultasi, atau melakukan pemesanan secara langsung.
                </p>

                <div class="map-box">
                    <iframe
                        src="https://www.google.com/maps?q=Kota+Mataram+NTB&output=embed"
                        loading="lazy"
                        allowfullscreen=""
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <div class="location-detail">
                    <div class="location-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <div>
                            <h4>Alamat</h4>
                            <p>Jl. Pelor Mas Raya No.III, Kekalik Jaya, Sekarbela, Kota Mataram, NTB</p>
                        </div>
                    </div>
                    <div class="location-item">
                        <i class="fa-solid fa-phone"></i>
                        <div>
                            <h4>Telepon</h4>
                            <p>0819-4671-6865</p>
                        </div>
                    </div>
                    <div class="location-item">
                        <i class="fa-solid fa-envelope"></i>
                        <div>
                            <h4>Email</h4>
                            <p>erlisnaflorist@gmail.com</p>
                        </div>
                    </div>
                    <div class="location-item">
                        <i class="fa-solid fa-clock"></i>
                        <div>
                            <h4>Jam Operasional</h4>
                            <p>Senin - Minggu<br>08.00 - 21.00 WITA</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= FAQ ================= -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <span>❓ FAQ</span>
            <h2>Pertanyaan yang Sering Diajukan</h2>
            <p>Berikut beberapa pertanyaan yang paling sering ditanyakan pelanggan Erlisna Florist.</p>
        </div>

        <div class="product-grid">
            <div class="card">
                <div class="card-body">
                    <h3>🌷 Apakah Bisa Custom Bouquet?</h3>
                    <p>Ya. Anda dapat menentukan jenis bunga, warna, ukuran, hingga budget sesuai keinginan.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>🚚 Apakah Melayani Pengiriman?</h3>
                    <p>Kami melayani pengiriman dalam kota maupun luar kota sesuai ketentuan yang berlaku.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>💳 Metode Pembayaran</h3>
                    <p>Transfer Bank, QRIS, dan pembayaran langsung di toko.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>⏰ Berapa Lama Proses Pengerjaan?</h3>
                    <p>Pemesanan normal sekitar 1-3 jam, sedangkan custom bouquet menyesuaikan desain.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CALL TO ACTION ================= -->
<section class="cta">
    <div class="container">
        <h2>🌸 Siap Memberikan Kejutan Terindah?</h2>
        <p>
            Temukan berbagai bouquet bunga terbaik untuk wisuda, ulang tahun, anniversary,
            pernikahan, dan berbagai momen spesial lainnya.
        </p>
        <div class="hero-btns" style="justify-content:center;margin-top:20px;">
            <a href="produk.php" class="btn-primary">
                <i class="fa-solid fa-cart-shopping"></i> Belanja Sekarang
            </a>
            <a href="https://wa.me/6281946716865" target="_blank" class="btn-wa">
                <i class="fab fa-whatsapp"></i> Chat WhatsApp
            </a>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>

</body>
</html>
