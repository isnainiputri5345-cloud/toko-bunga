# TODO: Perbaikan Semua Fitur Website Toko Bunga

## A. Perbaikan Error SQL (kolom legacy)
- [x] `admin/laporan.php`: `total_harga` → `total`, `tanggal_pesan` → `tanggal` (sudah benar)
- [x] `admin/pesanan.php`: `total_harga` → `total`, `tanggal_pesan` → `tanggal` (sudah benar)

## B. Perbaikan Link Rusak
- [x] `produk.php`: `detail_produk.php` → `detail.php` (sudah benar)
- [x] `index.php`: `detail_produk.php` → `detail.php`; path gambar produk `uploads/` (sudah benar)
- [x] `includes/header.php`: `edit_profile.php` → `edit_profil.php` (sudah benar)
- [x] `navbar.php`: `edit_profil.php`, kategori pakai `id_kategori` (sudah benar)

## C. Alur Beli Sekarang
- [x] `detail.php`: form "Beli Sekarang" add ke keranjang + redirect checkout (sudah benar)
- [x] `keranjang.php`: tangani flag `beli`/`tambah`, redirect ke checkout (sudah benar)

## D. Detail Pesanan
- [x] `pelanggan/detail_pesanan.php`: JOIN pelanggan utk alamat, hapus `alamat_pengiriman` (sudah benar)

## E. Bersihkan File Temp
- [x] Hapus `_schema_check.php`, `_data_check.php`, `_apply_fix.php`, `_verify.php`, `_verify2.php`, `_final_check.php`, `_check_pesan.php`, `_create_pesan.php`, `test.php`, `_verify_db.php`

## F. Verifikasi
- [x] PHP lint semua file yang diubah (tidak ada error sintaks)
- [x] Cek skema DB: `pesanan` pakai `tanggal`/`total`; `checkout` & `konfirmasi` pakai status valid (enum) `Menunggu`
