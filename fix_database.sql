-- Perbaikan database Erlisna Florist
-- Tambahkan kolom foto ke tabel pelanggan (jika belum ada)
ALTER TABLE `pelanggan` ADD COLUMN `foto` VARCHAR(255) DEFAULT NULL;

-- Buat tabel pesan untuk form kontak (jika belum ada)
CREATE TABLE IF NOT EXISTS `pesan` (
    `id_pesan` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telepon` VARCHAR(20) NOT NULL,
    `subjek` VARCHAR(150) DEFAULT NULL,
    `pesan` TEXT NOT NULL,
    `tanggal_pesan` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
