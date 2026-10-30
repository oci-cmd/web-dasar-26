<?php
// controllers/UserController.php - Pengatur Alur CRUD Pengguna
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    // 1. Tampilkan Halaman Tabel Utama
    public function index() {
        $users = $this->model->getAll();
        require_once __DIR__ . '/../views/index.php';
    }

    // 2. Formulir & Proses Tambah Data
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $nama     = trim($_POST['nama_lengkap'] ?? '');
            $role     = trim($_POST['role'] ?? '');
            $email    = trim($_POST['email'] ?? '');

            if (!empty($username) && !empty($nama)) {
                $this->model->create($username, $nama, $role, $email);
                header('Location: index.php');
                exit;
            }
        }
        require_once __DIR__ . '/../views/create.php';
    }

    // 3. Formulir & Proses Edit Data
    public function edit() {
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->model->getById($id);
        if (!$user) {
            die('Data pengguna tidak ditemukan!');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $nama     = trim($_POST['nama_lengkap'] ?? '');
            $role     = trim($_POST['role'] ?? '');
            $email    = trim($_POST['email'] ?? '');

            if (!empty($username) && !empty($nama)) {
                $this->model->update($id, $username, $nama, $role, $email);
                header('Location: index.php');
                exit;
            }
        }
        require_once __DIR__ . '/../views/edit.php';
    }

    // 4. Proses Hapus Data
    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->model->delete($id);
        }
        header('Location: index.php');
        exit;
    }
}
