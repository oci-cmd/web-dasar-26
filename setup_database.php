<?php
/**
 * Setup & Migrasi Basis Data Otomatis (One-Click Database Initializer)
 * Portal Praktikum Pemrograman Web Dasar - STMIK IKMI Cirebon
 * Domain: webdasar26.designme.my.id
 */

require_once __DIR__ . '/config/database.php';
$env = AppDatabase::getEnv();

$actionMsg = null;
$actionStatus = null;
$detailsLog = [];

// Handle Form Submission (Simpan Konfigurasi atau Jalankan Migrasi)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_config') {
        $newHost = trim($_POST['db_host'] ?? '127.0.0.1');
        $newPort = trim($_POST['db_port'] ?? '3306');
        $newDbUser = trim($_POST['db_user'] ?? 'root');
        $newDbPass = $_POST['db_pass'] ?? '';
        $useSingle = isset($_POST['use_single_db']);
        $singleDb = trim($_POST['single_db_name'] ?? '');

        $customContent = "<?php\nreturn [\n"
            . "    'DB_HOST' => " . var_export($newHost, true) . ",\n"
            . "    'DB_PORT' => " . var_export($newPort, true) . ",\n"
            . "    'DB_USER' => " . var_export($newDbUser, true) . ",\n"
            . "    'DB_PASS' => " . var_export($newDbPass, true) . ",\n"
            . "    'USE_SINGLE_DB' => " . ($useSingle ? 'true' : 'false') . ",\n"
            . "    'SINGLE_DB_NAME' => " . var_export($singleDb, true) . ",\n"
            . "];\n";

        if (file_put_contents(__DIR__ . '/config/config.custom.php', $customContent) !== false) {
            $actionMsg = "Konfigurasi basis data berhasil diperbarui!";
            $actionStatus = "success";
            $env = require __DIR__ . '/config/env.php';
        } else {
            $actionMsg = "Gagal menyimpan file konfigurasi. Periksa permission direktori config/";
            $actionStatus = "error";
        }
    }

    if ($action === 'run_migration') {
        $conn = AppDatabase::getServerConnection();
        if (!$conn) {
            $actionMsg = "Gagal terhubung ke MySQL Server pada host {$env['DB_HOST']}:{$env['DB_PORT']} dengan user '{$env['DB_USER']}'. Pastikan MySQL/MariaDB menyala!";
            $actionStatus = "error";
        } else {
            $successCount = 0;
            $errCount = 0;

            // 1. Setup db_akuntansi (KA P12, P13, P15)
            $dbA = $env['DB_AKUNTANSI'];
            @mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbA` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            if (@mysqli_select_db($conn, $dbA)) {
                $q1 = "CREATE TABLE IF NOT EXISTS `kas_pabrik` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `bk` VARCHAR(20) NOT NULL,
                    `ket` VARCHAR(100) NOT NULL,
                    `tipe` ENUM('Masuk', 'Keluar') NOT NULL,
                    `nm` DECIMAL(15,2) NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;";
                mysqli_query($conn, $q1);

                $q2 = "CREATE TABLE IF NOT EXISTS `master_rekening` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `kd` VARCHAR(20) NOT NULL UNIQUE,
                    `nm` VARCHAR(100) NOT NULL,
                    `kt` ENUM('Aset', 'Kewajiban', 'Ekuitas', 'Pendapatan', 'Beban') NOT NULL,
                    `sld` DECIMAL(15,2) NOT NULL DEFAULT 0,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;";
                mysqli_query($conn, $q2);

                // Sample seed data if empty
                $cntKas = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `kas_pabrik`"))[0];
                if ($cntKas == 0) {
                    mysqli_query($conn, "INSERT INTO `kas_pabrik` (`bk`, `ket`, `tipe`, `nm`) VALUES 
                        ('BKM-001', 'Penerimaan Piutang Penjualan Distributor', 'Masuk', 15000000.00),
                        ('BKK-001', 'Pembelian Bahan Baku Logam Batch 1', 'Keluar', 6500000.00),
                        ('BKK-002', 'Beban Listrik & Utilitas Pabrik', 'Keluar', 2300000.00)");
                }

                $cntRek = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `master_rekening`"))[0];
                if ($cntRek == 0) {
                    mysqli_query($conn, "INSERT INTO `master_rekening` (`kd`, `nm`, `kt`, `sld`) VALUES
                        ('1101', 'Kas Operasional Pabrik', 'Aset', 45000000.00),
                        ('1102', 'Bank BNI Rekening Perusahaan', 'Aset', 125000000.00),
                        ('2101', 'Hutang Dagang Supplier', 'Kewajiban', 18000000.00),
                        ('3101', 'Modal Disetor Pemilik', 'Ekuitas', 150000000.00),
                        ('4101', 'Pendapatan Operasional', 'Pendapatan', 85000000.00)");
                }

                $detailsLog[] = "Database `$dbA` siap: tabel `kas_pabrik` & `master_rekening` terpasang.";
                $successCount++;
            } else {
                $errCount++;
                $detailsLog[] = "Gagal inisialisasi database `$dbA`: " . mysqli_error($conn);
            }

            // 2. Setup db_pabrik (SI P13)
            $dbP = $env['DB_PABRIK'];
            @mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbP` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            if (@mysqli_select_db($conn, $dbP)) {
                $q3 = "CREATE TABLE IF NOT EXISTS `part_mesin` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `kd` VARCHAR(20) NOT NULL UNIQUE,
                    `nm` VARCHAR(100) NOT NULL,
                    `stok` INT NOT NULL DEFAULT 0,
                    `harga` DECIMAL(15,2) NOT NULL DEFAULT 0,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;";
                mysqli_query($conn, $q3);

                $cntPart = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `part_mesin`"))[0];
                if ($cntPart == 0) {
                    mysqli_query($conn, "INSERT INTO `part_mesin` (`kd`, `nm`, `stok`, `harga`) VALUES
                        ('PM-01', 'Bearing Roller Baja SKF-6205', 45, 125000.00),
                        ('PM-02', 'V-Belt Industrial Type B-52', 80, 85000.00),
                        ('PM-03', 'Hydraulic Piston Seal Ø60mm', 4, 340000.00),
                        ('PM-04', 'Sprocket Rantai Mesin 40T', 12, 210000.00),
                        ('PM-05', 'Electric Motor Induction 3-Phase', 3, 2750000.00)");
                }
                $detailsLog[] = "Database `$dbP` siap: tabel `part_mesin` terpasang.";
                $successCount++;
            } else {
                $errCount++;
                $detailsLog[] = "Gagal inisialisasi database `$dbP`: " . mysqli_error($conn);
            }

            // 3. Setup db_web_dasar (KA Mini Projek User Management)
            $dbU = $env['DB_NAME_KA_MINI'];
            @mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbU` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            if (@mysqli_select_db($conn, $dbU)) {
                $q4 = "CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(100) NOT NULL,
                    `email` VARCHAR(100) NOT NULL UNIQUE,
                    `role` ENUM('admin', 'operator', 'kasir') DEFAULT 'operator',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;";
                mysqli_query($conn, $q4);

                $cntUser = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `users`"))[0];
                if ($cntUser == 0) {
                    mysqli_query($conn, "INSERT INTO `users` (`name`, `email`, `role`) VALUES
                        ('Rosidin, M.Kom.', 'dosen@ikmi.ac.id', 'admin'),
                        ('Ahmad Fauzi', 'fauzi@akuntansi.my.id', 'kasir'),
                        ('Siti Nurhaliza', 'siti@akuntansi.my.id', 'operator')");
                }
                $detailsLog[] = "Database `$dbU` siap: tabel `users` KA Mini Project terpasang.";
                $successCount++;
            } else {
                $errCount++;
                $detailsLog[] = "Gagal inisialisasi database `$dbU`: " . mysqli_error($conn);
            }

            // 4. Setup mini_project_si (SI Mini Projek Enterprise)
            $dbS = $env['DB_NAME_SI_MINI'];
            @mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$dbS` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            if (@mysqli_select_db($conn, $dbS)) {
                $qUsers = "CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `username` VARCHAR(50) NOT NULL UNIQUE,
                    `password` VARCHAR(255) NOT NULL,
                    `nama_lengkap` VARCHAR(100) NOT NULL,
                    `role` ENUM('admin', 'manager', 'staff') NOT NULL DEFAULT 'staff',
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;";
                mysqli_query($conn, $qUsers);

                $qSuppliers = "CREATE TABLE IF NOT EXISTS `suppliers` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `kode_supplier` VARCHAR(20) NOT NULL UNIQUE,
                    `nama_perusahaan` VARCHAR(150) NOT NULL,
                    `kategori_produk` VARCHAR(100) NOT NULL,
                    `kriteria_kualitas` DECIMAL(5,2) NOT NULL,
                    `kriteria_harga` DECIMAL(5,2) NOT NULL,
                    `kriteria_pengiriman` DECIMAL(5,2) NOT NULL,
                    `kriteria_layanan` DECIMAL(5,2) NOT NULL,
                    `status_rekanan` ENUM('Aktif', 'Evaluasi', 'Nonaktif') NOT NULL DEFAULT 'Evaluasi',
                    `created_by` INT NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB;";
                mysqli_query($conn, $qSuppliers);

                $qAudit = "CREATE TABLE IF NOT EXISTS `audit_logs` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `user_id` INT NULL,
                    `username` VARCHAR(50) NOT NULL,
                    `action` VARCHAR(50) NOT NULL,
                    `module` VARCHAR(50) NOT NULL,
                    `details` TEXT NOT NULL,
                    `ip_address` VARCHAR(45) NOT NULL,
                    `user_agent` TEXT NOT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB;";
                mysqli_query($conn, $qAudit);

                // Seed users jika belum ada
                $cntAdmin = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `users` WHERE `username` = 'admin'"))[0];
                if ($cntAdmin == 0) {
                    $passHashAdmin = password_hash('admin123', PASSWORD_BCRYPT);
                    $passHashMgr   = password_hash('manager123', PASSWORD_BCRYPT);
                    $passHashStf   = password_hash('staff123', PASSWORD_BCRYPT);

                    $stmt = mysqli_prepare($conn, "INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `role`) VALUES 
                        ('admin', ?, 'Administrator Utama', 'admin'),
                        ('manager', ?, 'Hendrawan, M.M. (Pengadaan)', 'manager'),
                        ('staff', ?, 'Siti Rahmawati (Staff Entry)', 'staff')");
                    mysqli_stmt_bind_param($stmt, "sss", $passHashAdmin, $passHashMgr, $passHashStf);
                    mysqli_stmt_execute($stmt);
                }

                // Seed sample suppliers jika belum ada
                $cntSup = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM `suppliers`"))[0];
                if ($cntSup == 0) {
                    $adminId = mysqli_fetch_row(mysqli_query($conn, "SELECT `id` FROM `users` WHERE `username` = 'admin'"))[0] ?? 1;
                    mysqli_query($conn, "INSERT INTO `suppliers` (`kode_supplier`, `nama_perusahaan`, `kategori_produk`, `kriteria_kualitas`, `kriteria_harga`, `kriteria_pengiriman`, `kriteria_layanan`, `status_rekanan`, `created_by`) VALUES
                        ('SUP-001', 'PT. Mitra Logistik Sentosa', 'Penyedia Bahan Baku A', 88.00, 75.00, 92.00, 85.00, 'Aktif', $adminId),
                        ('SUP-002', 'CV. Prima Distribusi Cirebon', 'Komponen Kemasan', 82.00, 88.00, 80.00, 78.00, 'Aktif', $adminId),
                        ('SUP-003', 'PT. Samudra Packaging Solusi', 'Kemasan Industri', 95.00, 65.00, 85.00, 90.00, 'Evaluasi', $adminId)");
                }

                $detailsLog[] = "Database `$dbS` siap: tabel `users`, `suppliers`, & `audit_logs` terpasang (Default: admin/admin123, manager/manager123, staff/staff123).";
                $successCount++;
            } else {
                $errCount++;
                $detailsLog[] = "Gagal inisialisasi database `$dbS`: " . mysqli_error($conn);
            }

            $conn->close();

            if ($errCount === 0) {
                $actionMsg = "Migrasi sukses! Seluruh $successCount database dan skema tabel telah siap 100%.";
                $actionStatus = "success";
            } else {
                $actionMsg = "Migrasi selesai dengan beberapa catatan. Periksa rincian log di bawah.";
                $actionStatus = "warning";
            }
        }
    }
}

// Ambil status diagnostik terkini
$diag = AppDatabase::getDiagnostics();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup & Diagnostics — <?= htmlspecialchars($env['APP_DOMAIN']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .setup-container {
            max-width: 960px;
            margin: 40px auto;
            padding: 0 20px 60px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .status-badge.online {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .status-badge.offline {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .db-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            margin: 20px 0 30px;
        }
        .db-item {
            background: var(--surface-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
        }
        .db-item h4 {
            margin: 0 0 6px;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .form-panel {
            background: var(--surface-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 6px;
            color: var(--text-muted);
        }
        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: var(--surface-input);
            color: var(--text-main);
            font-family: inherit;
            font-size: 0.95rem;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .log-box {
            background: #0f172a;
            color: #38bdf8;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
            padding: 16px 20px;
            border-radius: 12px;
            margin-top: 20px;
            line-height: 1.6;
        }
    </style>
</head>
<body class="dark-theme">
    <div class="setup-container">
        <header style="margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <a href="index.php" style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                    ← Kembali ke Dashboard Portal
                </a>
                <h1 style="margin: 0; font-size: 1.8rem; font-weight: 800;">⚙️ Setup & Diagnostik Basis Data</h1>
                <p style="margin: 4px 0 0; color: var(--text-muted);">
                    Inisialisasi otomatis seluruh tabel praktikum KA, SI, dan Mini Projek MVC untuk XAMPP & Server Live.
                </p>
            </div>
            <div>
                <?php if ($diag['server_connected']): ?>
                    <span class="status-badge online">● MySQL Server Aktif (v<?= htmlspecialchars($diag['server_version'] ?? '') ?>)</span>
                <?php else: ?>
                    <span class="status-badge offline">● MySQL Offline / Terputus</span>
                <?php endif; ?>
            </div>
        </header>

        <?php if ($actionMsg): ?>
            <div style="padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; gap: 10px;
                <?= $actionStatus === 'success' ? 'background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3);' : 'background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3);' ?>">
                <span><?= $actionStatus === 'success' ? '✅' : '⚠️' ?></span>
                <span><?= htmlspecialchars($actionMsg) ?></span>
            </div>
        <?php endif; ?>

        <!-- Panel Status Database -->
        <h3 style="margin-bottom: 12px; font-size: 1.2rem;">Status Database Praktikum:</h3>
        <div class="db-card-grid">
            <?php foreach ($diag['databases'] as $dbName => $info): ?>
                <div class="db-item">
                    <h4>
                        <span><?= htmlspecialchars($dbName) ?></span>
                        <?php if ($info['exists']): ?>
                            <span style="font-size: 0.75rem; background: rgba(16,185,129,0.2); color: #10b981; padding: 2px 8px; border-radius: 999px;">Terpasang</span>
                        <?php else: ?>
                            <span style="font-size: 0.75rem; background: rgba(239,68,68,0.2); color: #ef4444; padding: 2px 8px; border-radius: 999px;">Belum Ada</span>
                        <?php endif; ?>
                    </h4>
                    <p style="margin: 0 0 10px; font-size: 0.85rem; color: var(--text-muted);"><?= htmlspecialchars($info['label']) ?></p>
                    <div style="font-size: 0.8rem; font-family: 'JetBrains Mono', monospace; color: var(--text-muted);">
                        <?php if ($info['exists'] && !empty($info['tables'])): ?>
                            <strong>Tabel:</strong> <?= implode(', ', array_map('htmlspecialchars', $info['tables'])) ?>
                        <?php elseif ($info['exists']): ?>
                            <em>Tabel belum diinisialisasi.</em>
                        <?php else: ?>
                            <em>Klik tombol di bawah untuk membuat otomatis.</em>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol Aksi Utama Migrasi -->
        <div class="form-panel" style="text-align: center; border: 2px dashed var(--primary); background: rgba(59, 130, 246, 0.03);">
            <h3 style="margin: 0 0 8px; font-size: 1.3rem;">🚀 One-Click Database Initializer</h3>
            <p style="color: var(--text-muted); max-width: 650px; margin: 0 auto 20px; font-size: 0.95rem;">
                Tombol ini akan otomatis membuat 4 database (<code style="color:var(--primary);">db_akuntansi</code>, <code style="color:var(--primary);">db_pabrik</code>, <code style="color:var(--primary);">db_web_dasar</code>, <code style="color:var(--primary);">mini_project_si</code>), memasang seluruh skema tabel, dan menyuntikkan data awal (seed data) yang siap diuji!
            </p>
            <form method="POST" style="display: inline-block;">
                <input type="hidden" name="action" value="run_migration">
                <button type="submit" class="btn btn-primary" style="padding: 14px 32px; font-size: 1.05rem; font-weight: 700; cursor: pointer; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px;">
                    <span>⚡ Jalankan Inisialisasi & Migrasi Database Sekarang</span>
                </button>
            </form>
        </div>

        <?php if (!empty($detailsLog)): ?>
            <div class="log-box">
                <div style="color: #94a3b8; font-weight: 600; margin-bottom: 8px;"># Rincian Eksekusi Migrasi:</div>
                <?php foreach ($detailsLog as $logLine): ?>
                    <div>&gt; <?= htmlspecialchars($logLine) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Form Konfigurasi Kredensial MySQL -->
        <div class="form-panel" style="margin-top: 30px;">
            <h3 style="margin: 0 0 6px; font-size: 1.2rem;">Kredensial Server Database</h3>
            <p style="margin: 0 0 20px; font-size: 0.85rem; color: var(--text-muted);">
                Sesuaikan kredensial di bawah jika Anda menggunakan password MySQL kustom (misal di aaPanel / cPanel server).
            </p>
            <form method="POST">
                <input type="hidden" name="action" value="save_config">
                <div class="form-row">
                    <div class="form-group">
                        <label>DB Host</label>
                        <input type="text" name="db_host" value="<?= htmlspecialchars($env['DB_HOST']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>DB Port</label>
                        <input type="text" name="db_port" value="<?= htmlspecialchars((string)$env['DB_PORT']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>DB User</label>
                        <input type="text" name="db_user" value="<?= htmlspecialchars($env['DB_USER']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>DB Password</label>
                        <input type="password" name="db_pass" value="<?= htmlspecialchars($env['DB_PASS']) ?>" placeholder="(Kosongkan jika default XAMPP)">
                    </div>
                </div>

                <div style="margin-top: 14px; text-align: right;">
                    <button type="submit" class="btn btn-secondary" style="padding: 10px 24px; font-weight: 600; border-radius: 10px; cursor: pointer;">
                        Simpan Kredensial
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
