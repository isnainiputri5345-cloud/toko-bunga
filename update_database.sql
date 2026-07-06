-- Tambahkan kolom foto ke tabel pelanggan
ALTER TABLE pelanggan ADD COLUMN foto VARCHAR(255) DEFAULT NULL;

-- Jika sudah ada kolom, gunakan query di bawah untuk perbarui:
-- ALTER TABLE pelanggan MODIFY COLUMN foto VARCHAR(255) DEFAULT NULL;
