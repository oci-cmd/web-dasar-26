<?php
// models/Supplier.php - Model Rekanan & Engine Algoritma SAW
require_once __DIR__ . '/../config/Database.php';

class Supplier {
    private PDO $db;

    // Bobot Kriteria Seleksi Pengadaan (Total W = 1.00)
    // C1: Kualitas (35% - Benefit), C2: Harga/Efisiensi (25% - Cost)
    // C3: Ketepatan Pengiriman (25% - Benefit), C4: Layanan (15% - Benefit)
    private const WEIGHTS = [
        'kualitas'   => 0.35,
        'harga'      => 0.25,
        'pengiriman' => 0.25,
        'layanan'    => 0.15
    ];

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        $sql = 'SELECT s.*, u.nama_lengkap AS pembuat FROM suppliers s 
                LEFT JOIN users u ON s.created_by = u.id ORDER BY s.id ASC';
        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): bool {
        $sql = 'INSERT INTO suppliers (kode_supplier, nama_perusahaan, kategori_produk, 
                kriteria_kualitas, kriteria_harga, kriteria_pengiriman, kriteria_layanan, status_rekanan, created_by) 
                VALUES (:kode, :nama, :kategori, :kualitas, :harga, :pengiriman, :layanan, :status, :created_by)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':kode'       => $data['kode_supplier'],
            ':nama'       => $data['nama_perusahaan'],
            ':kategori'   => $data['kategori_produk'],
            ':kualitas'   => $data['kriteria_kualitas'],
            ':harga'      => $data['kriteria_harga'],
            ':pengiriman' => $data['kriteria_pengiriman'],
            ':layanan'    => $data['kriteria_layanan'],
            ':status'     => $data['status_rekanan'],
            ':created_by' => $_SESSION['user_id']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM suppliers WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    // ENGINE ALGORITMA SPK: SIMPLE ADDITIVE WEIGHTING (SAW)
    public function calculateSAW(array $suppliers): array {
        if (empty($suppliers)) return [];

        // 1. Tentukan Nilai Max (Benefit) & Min (Cost)
        $maxKualitas   = max(array_column($suppliers, 'kriteria_kualitas'));
        $minHarga      = min(array_column($suppliers, 'kriteria_harga'));
        $maxPengiriman = max(array_column($suppliers, 'kriteria_pengiriman'));
        $maxLayanan    = max(array_column($suppliers, 'kriteria_layanan'));

        $results = [];
        foreach ($suppliers as $item) {
            // 2. Normalisasi Matriks R
            $rKualitas   = ($maxKualitas > 0) ? ($item['kriteria_kualitas'] / $maxKualitas) : 0;
            $rHarga      = ($item['kriteria_harga'] > 0) ? ($minHarga / $item['kriteria_harga']) : 0; // Cost
            $rPengiriman = ($maxPengiriman > 0) ? ($item['kriteria_pengiriman'] / $maxPengiriman) : 0;
            $rLayanan    = ($maxLayanan > 0) ? ($item['kriteria_layanan'] / $maxLayanan) : 0;

            // 3. Hitung Nilai Preferensi Vi = SUM(Wj * Rij)
            $vScore = (self::WEIGHTS['kualitas'] * $rKualitas) +
                      (self::WEIGHTS['harga'] * $rHarga) +
                      (self::WEIGHTS['pengiriman'] * $rPengiriman) +
                      (self::WEIGHTS['layanan'] * $rLayanan);

            $item['saw_score'] = round($vScore, 4);
            $item['saw_grade'] = ($vScore >= 0.85) ? 'SANGAT DIREKOMENDASIKAN' : (($vScore >= 0.70) ? 'DIREKOMENDASIKAN' : 'PERTIMBANGKAN KEMBALI');
            $results[] = $item;
        }

        // 4. Urutkan Ranking dari Nilai Skor Tertinggi (Descending)
        usort($results, fn($a, $b) => $b['saw_score'] <=> $a['saw_score']);
        return $results;
    }
}
