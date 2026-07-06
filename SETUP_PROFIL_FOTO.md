# Setup Profil Pelanggan dengan Foto

## Langkah-langkah Setup:

### 1. Update Database
Jalankan query berikut di phpMyAdmin atau MySQL client:

```sql
ALTER TABLE pelanggan ADD COLUMN foto VARCHAR(255) DEFAULT NULL;
```

Atau jika kolom sudah ada:
```sql
ALTER TABLE pelanggan MODIFY COLUMN foto VARCHAR(255) DEFAULT NULL;
```

### 2. Pastikan Folder Uploads Ada
Buat folder `/uploads/` di root project (jika belum ada) untuk menyimpan foto profile.
Pastikan folder memiliki permission 755 atau writable.

### 3. Fitur yang Tersedia

✅ **Upload Foto dari File**
- Klik icon kamera di foto profile
- Pilih "Upload File"
- Pilih foto dari komputer/device
- Klik "Simpan Foto"

✅ **Ambil Foto dari Kamera (Desktop)**
- Klik icon kamera di foto profile
- Pilih "Ambil Foto"
- Kamera akan terbuka
- Klik "Ambil Foto" untuk capture
- Foto akan preview dan bisa di-upload

✅ **Ambil Foto dari Kamera (Mobile)**
- Klik icon kamera di foto profile
- Pilih "Ambil Foto"
- Device akan membuka kamera
- Ambil foto seperti biasa
- Foto akan ter-upload otomatis

### 4. Format File yang Didukung
- JPG / JPEG
- PNG
- GIF

### 5. Ukuran Foto
- Foto akan ditampilkan dalam lingkaran (150x150px)
- Gunakan foto dengan rasio 1:1 untuk hasil terbaik

## Catatan:
- Foto default menggunakan SVG jika belum ada foto
- Foto lama akan otomatis dihapus saat upload foto baru
- Nama file foto akan disimpan dengan format: profil_{id_pelanggan}_{timestamp}.{ext}
