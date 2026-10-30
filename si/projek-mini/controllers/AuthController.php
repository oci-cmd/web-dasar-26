<?php
// controllers/AuthController.php - Pengendali Otentikasi & Session Guard
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/Database.php';

class AuthController extends Controller {
    private PDO $db;
    private $auditModel;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->auditModel = $this->model('AuditLog');
    }

    public function login(): void {
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=supplier&action=index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Kueri aman menggunakan Prepared Statements
            $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch();

            // Verifikasi Password Hash Bcrypt
            if ($user && password_verify($password, $user['password'])) {
                // ANTI SESSION FIXATION: Wajib meregenerasi ID sesi setelah login
                session_regenerate_id(true);

                $_SESSION['user_id']      = $user['id'];
                $_SESSION['username']     = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['user_role']    = $user['role'];

                // Rekam Jejak Audit Sukses Login
                $this->auditModel->record('LOGIN_SUCCESS', 'AUTH', 'Pengguna berhasil terotentikasi ke sistem.');

                $_SESSION['flash_success'] = 'Selamat datang kembali, ' . htmlspecialchars($user['nama_lengkap']) . ' [' . strtoupper($user['role']) . ']';
                header('Location: index.php?controller=supplier&action=index');
                exit;
            } else {
                // Rekam Jejak Audit Gagal Login (Deteksi Percobaan Anomali / Brute Force)
                $this->auditModel->record('LOGIN_FAILED', 'AUTH', 'Percobaan login gagal untuk username: ' . $username);
                $error = 'Kombinasi Username dan Password tidak valid!';
                $this->view('auth/login', ['error' => $error]);
                return;
            }
        }
        $this->view('auth/login');
    }

    public function logout(): void {
        if (isset($_SESSION['user_id'])) {
            $this->auditModel->record('LOGOUT', 'AUTH', 'Pengguna keluar dari sesi aplikasi.');
        }
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
