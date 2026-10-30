-- 1. Buat Database Latihan
CREATE DATABASE IF NOT EXISTS `db_web_dasar`;
USE `db_web_dasar`;

-- 2. Buat 1 Tabel Tunggal: users (Hanya 5 Kolom Sederhana)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,          -- Kolom 1: ID Unik Pengguna
    `username` VARCHAR(50) NOT NULL UNIQUE,       -- Kolom 2: ID Akun Pengguna
    `nama_lengkap` VARCHAR(100) NOT NULL,         -- Kolom 3: Nama Lengkap Pengguna
    `role` VARCHAR(50) NOT NULL,                  -- Kolom 4: Peran / Hak Akses Pengguna
    `email` VARCHAR(100) NOT NULL                 -- Kolom 5: Alamat Email Resmi
) ENGINE=InnoDB;

-- 3. Data Awal Pengguna Sistem
INSERT INTO `users` (`username`, `nama_lengkap`, `role`, `email`) VALUES
('admin01', 'Dewi Lestari', 'Administrator', 'dewi.admin@perusahaan.com'),
('operator01', 'Ahmad Fauzi', 'Operator Staf', 'ahmad.fauzi@perusahaan.com'),
('spv01', 'Siti Maryam', 'Supervisor', 'siti.maryam@perusahaan.com');
