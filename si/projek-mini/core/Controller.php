<?php
// core/Controller.php - Induk Kontroler (Base Controller) Aplikasi

class Controller {
    // Memuat berkas Model yang diminta
    public function model(string $modelName) {
        $filePath = __DIR__ . '/../models/' . $modelName . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return new $modelName();
        }
        die('Model ' . htmlspecialchars($modelName) . ' tidak ditemukan!');
    }

    // Me-render tampilan View dengan membungkusnya di layout header & footer
    public function view(string $viewPath, array $data = []): void {
        // Ekstrak array variabel agar langsung dapat dipanggil di view
        extract($data);

        $headerFile = __DIR__ . '/../views/layout/header.php';
        $targetFile = __DIR__ . '/../views/' . $viewPath . '.php';
        $footerFile = __DIR__ . '/../views/layout/footer.php';

        if (file_exists($targetFile)) {
            require_once $headerFile;
            require_once $targetFile;
            require_once $footerFile;
        } else {
            die('Berkas view ' . htmlspecialchars($viewPath) . ' tidak ditemukan!');
        }
    }

    // Otentikasi Guard: Memastikan sesi pengguna aktif sebelum membuka modul
    public function requireAuth(): void {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash_error'] = 'Akses ditolak! Anda wajib melakukan otentikasi login terlebih dahulu.';
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    // Otorisasi Guard: Memastikan hak akses pengguna sesuai peran (RBAC)
    public function requireRole(array $allowedRoles): void {
        $this->requireAuth();
        $userRole = $_SESSION['user_role'] ?? 'guest';
        if (!in_array($userRole, $allowedRoles, true)) {
            $_SESSION['flash_error'] = 'Hak akses ditolak! Modul ini memerlukan otorisasi level: ' . implode(', ', $allowedRoles);
            header('Location: index.php?controller=supplier&action=index');
            exit;
        }
    }
}
