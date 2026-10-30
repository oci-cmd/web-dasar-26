<?php
/**
 * Konfigurasi Lingkungan Terpadu (Environment Configuration)
 * Portal Praktikum Pemrograman Web Dasar - STMIK IKMI Cirebon
 * Domain Target: webdasar26.designme.my.id
 */

// Muat custom config jika pengguna telah menyimpan konfigurasi via setup_database.php
$customConfigFile = __DIR__ . '/config.custom.php';
$customConfig = file_exists($customConfigFile) ? require $customConfigFile : [];

// Deteksi hostname server
$hostName = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isLiveServer = !in_array($hostName, ['localhost', '127.0.0.1', '::1']) && !str_starts_with($hostName, 'localhost:');

return array_merge([
    'APP_NAME'          => 'Portal Praktikum Pemrograman Web Dasar',
    'APP_DOMAIN'        => 'webdasar26.designme.my.id',
    'APP_CAMPUS'        => 'STMIK IKMI Cirebon',
    'ACADEMIC_YEAR'     => 'Ganjil 2026/2027',
    'IS_LIVE_SERVER'    => $isLiveServer,

    // Konfigurasi Basis Data (Default XAMPP / Localhost)
    'DB_HOST'           => '127.0.0.1',
    'DB_PORT'           => '3306',
    'DB_USER'           => 'root',
    'DB_PASS'           => '',

    // Daftar Nama Database Standar Modul Praktikum
    'DB_AKUNTANSI'      => 'db_akuntansi',     // Praktikum KA P12, P13, P15
    'DB_PABRIK'         => 'db_pabrik',        // Praktikum SI P13
    'DB_NAME_KA_MINI'   => 'db_web_dasar',     // Mini Projek KA (User & Kasir)
    'DB_NAME_SI_MINI'   => 'mini_project_si',  // Mini Projek SI (Enterprise SPK & Audit)

    // Opsi Single Database (jika di hosting cPanel/aaPanel hanya memiliki 1 database)
    'USE_SINGLE_DB'     => false,
    'SINGLE_DB_NAME'    => '',
], $customConfig);
