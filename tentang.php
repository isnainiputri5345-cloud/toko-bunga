<?php
session_start();
include "config/koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tentang Kami | Erlisna Florist</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>

        /* ==========================
           PAGE HERO
        ========================== */

        .about-hero{
            background:linear-gradient(135deg,#fff6fa,#ffe4ef);
            padding:90px 0;
            overflow:hidden;
        }

        .about-hero-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            align-items:center;
            gap:60px;
        }

        .about-hero .tag{
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

        .about-hero h1{
            font-size:46px;
            line-height:1.2;
            color:var(--primary);
            margin-bottom:20px;
            font-weight:700;
        }

        .about-hero p{
            font-size:17px;
            color:#666;
            line-height:1.8;
            margin-bottom:32px;
        }

        .about-hero .hero-btns{
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

        .about-hero-img{
            text-align:center;
        }

        .about-hero-img img{
            width:100%;
            max-width:480px;
            border-radius:25px;
            box-shadow:0 18px 40px rgba(0,0,0,.12);
        }

        /* ==========================
           TENTANG KAMI
        ========================== */

        .about-section{
            padding:90px 0;
            background:#fff;
        }

        .about-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:60px;
            align-items:center;
        }

        .about-image img{
            width:100%;
            border-radius:25px;
            box-shadow:0 18px 40px rgba(0,0,0,.10);
        }

        .about-content .tag{
            color:var(--primary);
            font-weight:600;
            letter-spacing:1px;
            margin-bottom:15px;
            display:inline-block;
        }

        .about-content h2{
            font-size:38px;
            color:var(--primary);
            margin-bottom:20px;
            line-height:1.3;
        }

        .about-content h3{
            font-size:22px;
            color:#333;
            margin-bottom:20px;
        }

        .about-content h3 b{
            color:var(--primary);
        }

        .about-content p{
            color:#666;
            line-height:1.9;
            margin-bottom:16px;
        }

        /* ==========================
           INFO CARD
        ========================== */

        .about-info{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
            margin:35px 0;
        }

        .info-card{
            background:#fff7fb;
            border-radius:15px;
            padding:25px 15px;
            text-align:center;
            border:1px solid #ffe3ef;
            transition:.3s;
        }

        .info-card:hover{
            transform:translateY(-6px);
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }

        .info-card i{
            font-size:30px;
            color:var(--primary);
            margin-bottom:12px;
        }

        .info-card h3{
            font-size:26px;
            color:#333;
            margin-bottom:5px;
        }

        .info-card p{
            font-size:14px;
            color:#777;
            margin:0;
        }

        /* ==========================
           VISI MISI
        ========================== */

        .vm-section{
            padding:90px 0;
            background:#fff7fb;
        }

        .vm-wrapper{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:30px;
            max-width:900px;
            margin:auto;
        }

        .vm-card{
            background:#fff;
            border-radius:20px;
            padding:40px 35px;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
            transition:.3s;
            border-top:5px solid var(--primary);
        }

        .vm-card:hover{
            transform:translateY(-8px);
            box-shadow:0 18px 35px rgba(0,0,0,.12);
        }

        .vm-card .vm-icon{
            width:70px;
            height:70px;
            background:#ffe4ef;
            color:var(--primary);
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
            margin-bottom:20px;
        }

        .vm-card h3{
            font-size:26px;
            color:var(--primary);
            margin-bottom:15px;
        }

        .vm-card p{
            color:#666;
            line-height:1.8;
        }

        .vm-card ul{
            list-style:none;
        }

        .vm-card ul li{
            color:#666;
            line-height:2;
            position:relative;
            padding-left:25px;
        }

        .vm-card ul li::before{
            content:"\f138";
            font-family:"Font Awesome 6 Free";
            font-weight:900;
            color:var(--primary);
            position:absolute;
            left:0;
        }

        /* ==========================
           MENGAPA KAMI
        ========================== */

        .why-section{
            padding:90px 0;
            background:#fff;
        }

        .why-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:25px;
            margin-top:40px;
        }

        .why-card{
            background:#fff7fb;
            border-radius:18px;
            padding:30px;
            text-align:center;
            border:1px solid #ffe3ef;
            transition:.3s;
        }

        .why-card:hover{
            transform:translateY(-8px);
            box-shadow:0 12px 28px rgba(0,0,0,.10);
        }

        .why-card i{
            font-size:38px;
            color:var(--primary);
            margin-bottom:15px;
        }

        .why-card h3{
            font-size:20px;
            color:#333;
            margin-bottom:10px;
        }

        .why-card p{
            color:#777;
            font-size:14px;
            line-height:1.7;
        }

        /* ==========================
           RESPONSIVE
        ========================== */

        @media(max-width:992px){
            .about-hero-grid,
            .about-grid{
                grid-template-columns:1fr;
                text-align:center;
            }
            .about-hero .hero-btns{
                justify-content:center;
            }
            .about-info{
                grid-template-columns:repeat(2,1fr);
            }
            .about-content .tag{
                margin-top:20px;
            }
            .vm-wrapper{
                grid-template-columns:1fr;
            }
        }

        @media(max-width:600px){
            .about-hero h1{
                font-size:34px;
            }
            .about-content h2{
                font-size:30px;
            }
            .about-info{
                grid-template-columns:1fr;
            }
            .about-hero-img img{
                max-width:320px;
            }
        }

    </style>

</head>

<body>

<?php include "includes/header.php"; ?>

<!-- ================= HERO ================= -->
<section class="about-hero">
    <div class="container about-hero-grid">
        <div class="about-hero-content">
            <span class="tag">🌸 Erlisna Florist</span>
            <h1>Membuat Setiap Momen Menjadi Lebih Berkesan</h1>
            <p>
                Erlisna Florist menyediakan berbagai rangkaian bunga berkualitas
                untuk wisuda, ulang tahun, anniversary, pernikahan, standing flower,
                hingga papan bunga dengan desain elegan dan pelayanan terbaik.
            </p>
            <div class="hero-btns">
                <a href="produk.php" class="btn-primary">
                    <i class="fas fa-store"></i> Lihat Produk
                </a>
                <a href="kontak.php" class="btn-secondary">
                    <i class="fas fa-phone"></i> Hubungi Kami
                </a>
            </div>
        </div>
        <div class="about-hero-img">
            <img src="assets/images/buket a1.jpg" alt="Buket Erlisna Florist">
        </div>
    </div>
</section>

<!-- ================= TENTANG KAMI ================= -->
<section class="about-section">
    <div class="container about-grid">
        <div class="about-image">
            <img src="assets/images/logo.png" alt="Erlisna Florist">
        </div>
        <div class="about-content">
            <span class="tag">🌸 Tentang Kami</span>
            <h2>Selamat Datang di Erlisna Florist</h2>
            <h3>Menyediakan Bunga Berkualitas <b>untuk Momen Spesial Anda</b></h3>
            <p>
                Erlisna Florist merupakan toko bunga yang menyediakan berbagai jenis
                rangkaian bunga berkualitas untuk memenuhi kebutuhan pelanggan dalam
                berbagai acara spesial.
            </p>
            <p>
                Kami melayani pemesanan bouquet wisuda, ulang tahun, anniversary,
                pernikahan, standing flower, papan bunga, flower box, bunga meja,
                serta berbagai rangkaian bunga custom sesuai dengan keinginan pelanggan.
            </p>
            <p>
                Setiap rangkaian bunga dibuat menggunakan bunga pilihan terbaik,
                dikombinasikan dengan desain modern dan elegan sehingga mampu
                memberikan kesan istimewa bagi penerimanya.
            </p>

            <div class="about-info">
                <div class="info-card">
                    <i class="fas fa-seedling"></i>
                    <h3>100%</h3>
                    <p>Bunga Segar</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-users"></i>
                    <h3>500+</h3>
                    <p>Pelanggan</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-gift"></i>
                    <h3>1000+</h3>
                    <p>Bouquet Terjual</p>
                </div>
                <div class="info-card">
                    <i class="fas fa-truck"></i>
                    <h3>24 Jam</h3>
                    <p>Pengiriman</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= VISI & MISI ================= -->
<section class="vm-section">
    <div class="container">
        <div class="section-title">
            <span>🌸 Komitmen Kami</span>
            <h2>Visi & Misi Kami</h2>
            <p>Berkomitmen menghadirkan bunga terbaik dengan pelayanan profesional.</p>
        </div>

        <div class="vm-wrapper">
            <div class="vm-card">
                <div class="vm-icon"><i class="fas fa-eye"></i></div>
                <h3>Visi</h3>
                <p>
                    Menjadi florist terbaik di Indonesia yang dikenal karena kualitas,
                    keindahan desain, serta pelayanan yang memuaskan.
                </p>
            </div>

            <div class="vm-card">
                <div class="vm-icon"><i class="fas fa-bullseye"></i></div>
                <h3>Misi</h3>
                <ul>
                    <li>Menyediakan bunga segar berkualitas.</li>
                    <li>Menghasilkan desain bouquet modern.</li>
                    <li>Pelayanan cepat dan ramah.</li>
                    <li>Pengiriman tepat waktu.</li>
                    <li>Kepuasan pelanggan prioritas utama.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ================= MENGAPA MEMILIH KAMI ================= -->
<section class="why-section">
    <div class="container">
        <div class="section-title">
            <span>🌸 Keunggulan Kami</span>
            <h2>Mengapa Memilih Erlisna Florist?</h2>
            <p>Kami selalu mengutamakan kualitas dan kepuasan pelanggan.</p>
        </div>

        <div class="why-grid">
            <div class="why-card">
                <i class="fas fa-seedling"></i>
                <h3>Bunga Segar</h3>
                <p>Menggunakan bunga pilihan dengan kualitas premium yang selalu segar.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-palette"></i>
                <h3>Desain Modern</h3>
                <p>Rangkaian bouquet dengan desain modern dan elegan sesuai tren.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-tags"></i>
                <h3>Harga Bersahabat</h3>
                <p>Harga terjangkau dengan kualitas yang tetap terbaik.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-truck-fast"></i>
                <h3>Pengiriman Cepat</h3>
                <p>Pengiriman tepat waktu untuk setiap momen spesial Anda.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-crown"></i>
                <h3>Custom Bouquet</h3>
                <p>Melayani bouquet custom sesuai dengan keinginan pelanggan.</p>
            </div>
            <div class="why-card">
                <i class="fas fa-headset"></i>
                <h3>Pelayanan Ramah</h3>
                <p>Tim kami siap membantu dengan pelayanan yang ramah dan profesional.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= GALERI ================= -->
<section class="section">
    <div class="container">
        <div class="section-title">
            <span>📸 Galeri Bunga</span>
            <h2>Inspirasi Rangkaian Bunga</h2>
            <p>Inspirasi rangkaian bunga Erlisna Florist untuk berbagai momen spesial.</p>
        </div>

        <div class="product-grid">
            <div class="card"><img src="assets/images/buket a4.jpg" alt="Bouquet"></div>
            <div class="card"><img src="assets/images/buket r1.jpg" alt="Bouquet"></div>
            <div class="card"><img src="assets/images/buket w2.jpg" alt="Bouquet"></div>
            <div class="card"><img src="assets/images/buket3.jpg" alt="Bouquet"></div>
        </div>
    </div>
</section>

<!-- ================= CALL TO ACTION ================= -->
<section class="cta">
    <div class="container">
        <h2>Siap Memberikan Kejutan Terindah?</h2>
        <p>
            Temukan berbagai pilihan bouquet bunga terbaik untuk wisuda, ulang tahun,
            anniversary, pernikahan, dan berbagai momen spesial lainnya.
        </p>
        <a href="produk.php" class="btn-primary">Belanja Sekarang</a>
    </div>
</section>

<?php include "includes/footer.php"; ?>

</body>
</html>
