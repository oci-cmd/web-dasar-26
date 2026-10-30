<?php
/**
 * Database Helper & Diagnostics Engine
 * Portal Praktikum Pemrograman Web Dasar - STMIK IKMI Cirebon
 */

require_once __DIR__ . '/env.php';

class AppDatabase {
    private static $env = null;

    public static function getEnv(): array {
        if (self::$env === null) {
            self::$env = require __DIR__ . '/env.php';
        }
        return self::$env;
    }

    /**
     * Dapatkan koneksi server MySQL murni (tanpa memilih database)
     */
    public static function getServerConnection(): ?mysqli {
        $env = self::getEnv();
        try {
            $mysqli = @mysqli_init();
            if (!$mysqli) return null;
            
            $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 2);
            $connected = @$mysqli->real_connect(
                $env['DB_HOST'],
                $env['DB_USER'],
                $env['DB_PASS'],
                null,
                (int)$env['DB_PORT']
            );
            return $connected ? $mysqli : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Dapatkan koneksi PDO untuk database tertentu
     */
    public static function getPdo(string $dbName): ?PDO {
        $env = self::getEnv();
        $targetDb = !empty($env['USE_SINGLE_DB']) && !empty($env['SINGLE_DB_NAME']) 
            ? $env['SINGLE_DB_NAME'] 
            : $dbName;

        try {
            $dsn = "mysql:host={$env['DB_HOST']};port={$env['DB_PORT']};dbname={$targetDb};charset=utf8mb4";
            return new PDO($dsn, $env['DB_USER'], $env['DB_PASS'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Dapatkan status ketersediaan MySQL dan Database
     */
    public static function getDiagnostics(): array {
        $env = self::getEnv();
        $conn = self::getServerConnection();
        $isServerUp = ($conn !== null);
        
        $dbStatus = [
            'server_connected' => $isServerUp,
            'host'             => $env['DB_HOST'],
            'port'             => $env['DB_PORT'],
            'user'             => $env['DB_USER'],
            'server_version'   => $isServerUp ? $conn->server_info : null,
            'databases'        => []
        ];

        $checkList = [
            'db_akuntansi'    => 'Praktikum KA (P12, P13, P15)',
            'db_pabrik'       => 'Praktikum SI (P13)',
            'db_web_dasar'    => 'Mini Projek KA (MVC User)',
            'mini_project_si' => 'Mini Projek SI (MVC Enterprise)',
        ];

        if ($isServerUp) {
            foreach ($checkList as $dbName => $label) {
                $dbExists = false;
                $tables = [];
                if ($res = @mysqli_query($conn, "SHOW DATABASES LIKE '$dbName'")) {
                    if (mysqli_num_rows($res) > 0) {
                        $dbExists = true;
                        // Cek tabel-tabel di dalamnya
                        if ($tRes = @mysqli_query($conn, "SHOW TABLES FROM `$dbName`")) {
                            while ($row = mysqli_fetch_array($tRes)) {
                                $tables[] = $row[0];
                            }
                        }
                    }
                }
                $dbStatus['databases'][$dbName] = [
                    'label'  => $label,
                    'exists' => $dbExists,
                    'tables' => $tables
                ];
            }
            $conn->close();
        } else {
            foreach ($checkList as $dbName => $label) {
                $dbStatus['databases'][$dbName] = [
                    'label'  => $label,
                    'exists' => false,
                    'tables' => []
                ];
            }
        }

        return $dbStatus;
    }
}
