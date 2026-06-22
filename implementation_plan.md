# Rencana Implementasi Perbaikan Kode Website Toko Bunga

Dokumen ini berisi rencana perbaikan terperinci untuk mengatasi seluruh kesalahan (error) tautan, masalah keamanan (session validation), rute pengalihan (redirect), logika laporan penjualan, serta struktur direktori yang hilang pada website Erlisna Florist.

## User Review Required

> [!IMPORTANT]
> - **Proteksi Keamanan Halaman Admin**: Kami akan menambahkan validasi session di seluruh berkas admin untuk memastikan hanya admin yang login yang dapat melihat atau mengubah data.
> - **Dynamic Path di Navigation Bar (`navbar.php`)**: Untuk mengatasi bentrok tautan antara halaman root dan halaman pelanggan, kami menggunakan deteksi folder dinamis. Tautan navigasi akan otomatis mendeteksi apakah pengguna sedang berada di dalam subfolder atau di root.

## Proposed Changes

---

### 1. Komponen Navigasi Utama

#### [MODIFY] [navbar.php](file:///c:/xampp/htdocs/toko_bunga/navbar.php)
* Mengubah tautan statis menjadi dinamis dengan mendeteksi posisi folder script saat ini (apakah berada di dalam subfolder `pelanggan` atau tidak).
* Menentukan `$base_root` dan `$base_pelanggan` secara dinamis, lalu menerapkannya ke setiap tag tautan (`<a>`).

---

### 2. Komponen Pelanggan (Customer Area)

#### [MODIFY] [pelanggan/dashboard.php](file:///c:/xampp/htdocs/toko_bunga/pelanggan/dashboard.php)
* Memperbaiki alamat pengalihan (redirect) dari `../login.php` ke `login.php`.

#### [MODIFY] [pelanggan/profil.php](file:///c:/xampp/htdocs/toko_bunga/pelanggan/profil.php)
* Memperbaiki alamat pengalihan ke `login.php` dan menambahkan fungsi `exit;` untuk menghentikan eksekusi script setelah pengalihan.

#### [MODIFY] [pelanggan/riwayat.php](file:///c:/xampp/htdocs/toko_bunga/pelanggan/riwayat.php)
* Memperbaiki alamat pengalihan ke `login.php` dan menambahkan fungsi `exit;` setelah `header()`.

#### [MODIFY] [pelanggan/edit_profil.php](file:///c:/xampp/htdocs/toko_bunga/pelanggan/edit_profil.php)
* Menambahkan validasi login di baris teratas agar halaman ini tidak dapat dibuka tanpa login pelanggan.

#### [MODIFY] [pelanggan/detail_pesanan.php](file:///c:/xampp/htdocs/toko_bunga/pelanggan/detail_pesanan.php)
* Menambahkan validasi login di baris teratas untuk alasan keamanan data pesanan.

---

### 3. Komponen Halaman Root

#### [MODIFY] [detail.php](file:///c:/xampp/htdocs/toko_bunga/detail.php)
* Memperbaiki link tombol login (line 83) yang mengarah ke `login.php` menjadi `pelanggan/login.php`.

#### [MODIFY] [keranjang.php](file:///c:/xampp/htdocs/toko_bunga/keranjang.php)
* Memperbaiki pengalihan JavaScript pada line 9 dari `login.php` menjadi `pelanggan/login.php`.

#### [MODIFY] [checkout.php](file:///c:/xampp/htdocs/toko_bunga/checkout.php)
* Memperbaiki pengalihan header PHP pada line 7 dari `login.php` menjadi `pelanggan/login.php`.

#### [MODIFY] [profil.php](file:///c:/xampp/htdocs/toko_bunga/profil.php)
* Memperbaiki pengalihan header PHP pada line 7 dari `login.php` menjadi `pelanggan/login.php`.
* Memastikan seluruh tautan internal mengarah ke lokasi yang konsisten.

#### [MODIFY] [logout.php](file:///c:/xampp/htdocs/toko_bunga/logout.php)
* Menambahkan `exit;` setelah fungsi pengalihan `header()`.

---

### 4. Komponen Administrasi (Admin Area)

#### [MODIFY] [admin/dashboard.php](file:///c:/xampp/htdocs/toko_bunga/admin/dashboard.php)
* Menambahkan fungsi `exit;` setelah pengecekan session yang mengalihkan ke `login.php`.

#### [MODIFY] [admin/edit_produk.php](file:///c:/xampp/htdocs/toko_bunga/admin/edit_produk.php)
* Menambahkan fungsi `exit;` setelah pengalihan ke `login.php`.

#### [MODIFY] [admin/produk.php](file:///c:/xampp/htdocs/toko_bunga/admin/produk.php)
#### [MODIFY] [admin/kategori.php](file:///c:/xampp/htdocs/toko_bunga/admin/kategori.php)
#### [MODIFY] [admin/tambah_produk.php](file:///c:/xampp/htdocs/toko_bunga/admin/tambah_produk.php)
#### [MODIFY] [admin/tambah_kategori.php](file:///c:/xampp/htdocs/toko_bunga/admin/tambah_kategori.php)
#### [MODIFY] [admin/edit_kategori.php](file:///c:/xampp/htdocs/toko_bunga/admin/edit_kategori.php)
#### [MODIFY] [admin/hapus_kategori.php](file:///c:/xampp/htdocs/toko_bunga/admin/hapus_kategori.php)
#### [MODIFY] [admin/hapus_produk.php](file:///c:/xampp/htdocs/toko_bunga/admin/hapus_produk.php)
#### [MODIFY] [admin/pesanan.php](file:///c:/xampp/htdocs/toko_bunga/admin/pesanan.php)
#### [MODIFY] [admin/laporan.php](file:///c:/xampp/htdocs/toko_bunga/admin/laporan.php)
* Menambahkan validasi session admin (`$_SESSION['admin']`) di baris paling atas berkas agar tidak dapat diakses langsung oleh publik.
* Menambahkan `exit;` setelah pengalihan halaman.

#### [MODIFY] [admin/laporan.php](file:///c:/xampp/htdocs/toko_bunga/admin/laporan.php)
* Mengubah logika kalkulasi pendapatan. Kami akan mengubah query penghitungan pendapatan agar menjumlahkan semua transaksi pesanan (atau berdasarkan status yang dianggap valid seperti status selesai/lunas jika nanti ditambahkan). Untuk saat ini, kami akan menghapus batasan `WHERE status='Menunggu'` atau mengubahnya agar merepresentasikan total pesanan yang masuk dengan benar.

#### [MODIFY] [admin/logout.php](file:///c:/xampp/htdocs/toko_bunga/admin/logout.php)
* Menambahkan `exit;` setelah fungsi pengalihan ke `login.php`.

---

### 5. Komponen Struktur File

#### [NEW] [uploads/.gitkeep](file:///c:/xampp/htdocs/toko_bunga/uploads/.gitkeep)
* Membuat berkas penanda kosong `.gitkeep` di dalam folder `uploads/` yang baru agar direktori `uploads` terbentuk di sisi lokal sistem pengguna. Hal ini mempermudah sistem dalam mengunggah foto bunga/produk baru.

---

## Verification Plan

### Automated Tests
- Menjalankan linter PHP (`C:\xampp\php\php.exe -l`) pada berkas-berkas yang dimodifikasi untuk memastikan tidak ada kesalahan sintaksis baru.

### Manual Verification
- Melakukan verifikasi alur login pelanggan dari halaman root.
- Membuka halaman dasbor pelanggan, profil, riwayat, dan memastikan tidak ada error 404 pada menu navigasi.
- Mencoba mengakses halaman admin langsung tanpa login (misal `admin/produk.php`) untuk memastikan pengalihan ke login admin berhasil dan script berhenti dieksekusi secara aman.
