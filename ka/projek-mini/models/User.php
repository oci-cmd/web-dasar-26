<?php
// models/User.php - Model CRUD Pengguna Sistem
require_once __DIR__ . '/../config/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // [READ ALL] Mengambil semua pengguna untuk ditampilkan di tabel
    public function getAll() {
        $stmt = $this->db->query('SELECT * FROM users ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    // [READ ONE] Mengambil 1 baris data pengguna berdasarkan ID untuk form edit
    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // [CREATE] Menambah baris data pengguna baru
    public function create($username, $nama, $role, $email) {
        $sql = 'INSERT INTO users (username, nama_lengkap, role, email) 
                VALUES (:username, :nama, :role, :email)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':nama'     => $nama,
            ':role'     => $role,
            ':email'    => $email
        ]);
    }

    // [UPDATE] Memperbarui data pengguna berdasarkan ID
    public function update($id, $username, $nama, $role, $email) {
        $sql = 'UPDATE users SET username = :username, nama_lengkap = :nama, 
                role = :role, email = :email WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'       => $id,
            ':username' => $username,
            ':nama'     => $nama,
            ':role'     => $role,
            ':email'    => $email
        ]);
    }

    // [DELETE] Menghapus data pengguna berdasarkan ID
    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}
