<?php
// config/Database.php - Kelas Koneksi PDO Aman
class Database {
    private static $host = '127.0.0.1';
    private static $db   = 'db_web_dasar';
    private static $user = 'root';
    private static $pass = '';
    private static $port = '3306';
    private static $pdo  = null;

    private static function initEnv(): void {
        $envFile = __DIR__ . '/../../config/env.php';
        if (file_exists($envFile)) {
            $env = require $envFile;
            if (!empty($env['DB_HOST'])) self::$host = $env['DB_HOST'];
            if (!empty($env['DB_PORT'])) self::$port = $env['DB_PORT'];
            if (!empty($env['DB_USER'])) self::$user = $env['DB_USER'];
            if (isset($env['DB_PASS'])) self::$pass = $env['DB_PASS'];
            if (!empty($env['USE_SINGLE_DB']) && !empty($env['SINGLE_DB_NAME'])) {
                self::$db = $env['SINGLE_DB_NAME'];
            } elseif (!empty($env['DB_NAME_KA_MINI'])) {
                self::$db = $env['DB_NAME_KA_MINI'];
            }
        }
    }

    public static function connect(): PDO {
        if (self::$pdo === null) {
            self::initEnv();
            try {
                $dsn = 'mysql:host=' . self::$host . ';port=' . self::$port . ';dbname=' . self::$db . ';charset=utf8mb4';
                self::$pdo = new PDO($dsn, self::$user, self::$pass, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false // MENCEGAH SQL INJECTION MUTLAK
                ]);
            } catch (PDOException $e) {
                die('<div style="font-family:sans-serif;max-width:600px;margin:40px auto;padding:24px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;">'
                    . '<h3 style="margin-top:0;">⚠️ Koneksi Basis Data Gagal</h3>'
                    . '<p>' . htmlspecialchars($e->getMessage()) . '</p>'
                    . '<p><a href="../../setup_database.php" style="display:inline-block;padding:8px 16px;background:#dc2626;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;">Jalankan Setup Database Otomatis</a></p>'
                    . '</div>');
            }
        }
        return self::$pdo;
    }
}
