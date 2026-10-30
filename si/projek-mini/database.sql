-- =====================================================================
-- SKEMA BASIS DATA ENTERPRISE: MINI-ERP, SPK SUPPLIER & AUDIT TRAIL
-- STMIK IKMI CIREBON - PRODI S1 SISTEM INFORMASI
-- =====================================================================
CREATE DATABASE IF NOT EXISTS `mini_project_si` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mini_project_si`;

-- 1. Tabel Pengguna Sistem Berbasis Peran (RBAC)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `role` ENUM('admin', 'manager', 'staff') NOT NULL DEFAULT 'staff',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabel Master Rekanan / Supplier & Variabel Evaluasi SPK SAW
CREATE TABLE IF NOT EXISTS `suppliers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `kode_supplier` VARCHAR(20) NOT NULL UNIQUE,
    `nama_perusahaan` VARCHAR(150) NOT NULL,
    `kategori_produk` VARCHAR(100) NOT NULL,
    `kriteria_kualitas` DECIMAL(5,2) NOT NULL COMMENT 'Skala 1 - 100 (Benefit)',
    `kriteria_harga` DECIMAL(5,2) NOT NULL COMMENT 'Skala 1 - 100 (Cost / Efisiensi Harga)',
    `kriteria_pengiriman` DECIMAL(5,2) NOT NULL COMMENT 'Skala 1 - 100 (Benefit / Ketepatan Waktu)',
    `kriteria_layanan` DECIMAL(5,2) NOT NULL COMMENT 'Skala 1 - 100 (Benefit / Responsivitas)',
    `status_rekanan` ENUM('Aktif', 'Evaluasi', 'Nonaktif') NOT NULL DEFAULT 'Evaluasi',
    `created_by` INT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- 3. Tabel Append-Only Audit Trail Forensik Keamanan
CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `username` VARCHAR(50) NOT NULL,
    `action` VARCHAR(50) NOT NULL COMMENT 'LOGIN_SUCCESS, CREATE_SUPPLIER, DELETE, dll',
    `module` VARCHAR(50) NOT NULL COMMENT 'AUTH, SUPPLIER, INVENTORY, dll',
    `details` TEXT NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `user_agent` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Benih Akun Default (Password hash Bcrypt: 'admin123', 'manager123', 'staff123')
INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator Utama', 'admin'),
(2, 'manager', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Hendrawan, M.M. (Pengadaan)', 'manager'),
(3, 'staff', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Siti Rahmawati (Staff Entry)', 'staff')
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Data Awal Alternatif Rekanan Supplier untuk Uji Coba SAW
INSERT INTO `suppliers` (`id`, `kode_supplier`, `nama_perusahaan`, `kategori_produk`, `kriteria_kualitas`, `kriteria_harga`, `kriteria_pengiriman`, `kriteria_layanan`, `status_rekanan`, `created_by`) VALUES
(1, 'SUP-001', 'PT. Mitra Logistik Sentosa', 'Penyedia Bahan Baku A', 88.00, 75.00, 92.00, 85.00, 'Aktif', 1),
(2, 'SUP-002', 'CV. Prima Distribusi Cirebon', 'Komponen Kemasan', 82.00, 88.00, 80.00, 78.00, 'Aktif', 1),
(3, 'SUP-003', 'PT. Samudra Packaging Solusi', 'Kemasan Industri', 95.00, 65.00, 85.00, 90.00, 'Evaluasi', 2)
ON DUPLICATE KEY UPDATE `id`=`id`;
