<?php
// models/AuditLog.php - Model Pencatatan Jejak Audit Digital (Append-Only)
require_once __DIR__ . '/../config/Database.php';

class AuditLog {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Mencatat aktivitas sistem secara transparan dan akuntabel
    public function record(string $action, string $module, string $details): bool {
        $userId = $_SESSION['user_id'] ?? null;
        $username = $_SESSION['username'] ?? 'ANONYMOUS_USER';
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN_IP';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN_BROWSER';

        $sql = 'INSERT INTO audit_logs (user_id, username, action, module, details, ip_address, user_agent) 
                VALUES (:user_id, :username, :action, :module, :details, :ip_address, :user_agent)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id'    => $userId,
            ':username'   => $username,
            ':action'     => $action,
            ':module'     => $module,
            ':details'    => $details,
            ':ip_address' => $ipAddress,
            ':user_agent' => $userAgent
        ]);
    }

    // Mengambil riwayat log aktivitas terbaru untuk inspeksi auditor
    public function getAll(int $limit = 100): array {
        $sql = 'SELECT * FROM audit_logs ORDER BY created_at DESC LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
