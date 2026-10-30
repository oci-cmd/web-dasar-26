<?php
// config/Database.php - Singleton Pattern Koneksi PDO Aman
class Database {
    private static ?PDO $instance = null;

    private static string $host = '127.0.0.1';
    private static string $user = 'root';
    private static string $pass = '';
    private static string $name = 'mini_project_si';
    private static string $port = '3306';

    // Mencegah instansiasi langsung dari luar (Singleton)
    private function __construct() {}
    private function __clone() {}

    private static function initEnv(): void {
        $envFile = __DIR__ . '/../../config/env.php';
        if (file_exists($envFile)) {
            $env = require $envFile;
            if (!empty($env['DB_HOST'])) self::$host = $env['DB_HOST'];
            if (!empty($env['DB_PORT'])) self::$port = (string)$env['DB_PORT'];
            if (!empty($env['DB_USER'])) self::$user = $env['DB_USER'];
            if (isset($env['DB_PASS'])) self::$pass = $env['DB_PASS'];
            if (!empty($env['USE_SINGLE_DB']) && !empty($env['SINGLE_DB_NAME'])) {
                self::$name = $env['SINGLE_DB_NAME'];
            } elseif (!empty($env['DB_NAME_SI_MINI'])) {
                self::$name = $env['DB_NAME_SI_MINI'];
            }
        }
    }

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::initEnv();
            $dsn = 'mysql:host=' . self::$host . ';port=' . self::$port . ';dbname=' . self::$name . ';charset=utf8mb4';
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                // NONAKTIFKAN EMULASI PREPARES UNTUK MENUTUP CELAH SQL INJECTION SECARA MUTLAK
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                self::$instance = new PDO($dsn, self::$user, self::$pass, $options);
            } catch (PDOException $e) {
                error_log('Database Connection Error: ' . $e->getMessage());
                die('<div style="font-family:sans-serif;max-width:600px;margin:40px auto;padding:24px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;">'
                    . '<h3 style="margin-top:0;">⚠️ Koneksi Basis Data Gagal</h3>'
                    . '<p>' . htmlspecialchars($e->getMessage()) . '</p>'
                    . '<p><a href="../../setup_database.php" style="display:inline-block;padding:8px 16px;background:#dc2626;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;">Jalankan Setup Database Otomatis</a></p>'
                    . '</div>');
            }
        }
        return self::$instance;
    }
}
