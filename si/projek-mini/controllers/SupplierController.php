<?php
// controllers/SupplierController.php - Orkestrator Pengadaan Rekanan & SPK
require_once __DIR__ . '/../core/Controller.php';

class SupplierController extends Controller {
    private $supplierModel;
    private $auditModel;

    public function __construct() {
        // Proteksi Otorisasi: Wajib login untuk seluruh aksi
        $this->requireAuth();
        $this->supplierModel = $this->model('Supplier');
        $this->auditModel = $this->model('AuditLog');
    }

    public function index(): void {
        $rawSuppliers = $this->supplierModel->getAll();
        // Jalankan Kalkulasi SPK SAW
        $rankedSuppliers = $this->supplierModel->calculateSAW($rawSuppliers);

        $this->view('supplier/index', [
            'suppliers' => $rankedSuppliers,
            'total'     => count($rawSuppliers)
        ]);
    }

    public function create(): void {
        // Otorisasi: Hanya Admin dan Manager yang berhak menambah data rekanan
        $this->requireRole(['admin', 'manager']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'kode_supplier'       => trim($_POST['kode_supplier'] ?? ''),
                'nama_perusahaan'     => trim($_POST['nama_perusahaan'] ?? ''),
                'kategori_produk'     => trim($_POST['kategori_produk'] ?? ''),
                'kriteria_kualitas'   => (float) ($_POST['kriteria_kualitas'] ?? 0),
                'kriteria_harga'      => (float) ($_POST['kriteria_harga'] ?? 0),
                'kriteria_pengiriman' => (float) ($_POST['kriteria_pengiriman'] ?? 0),
                'kriteria_layanan'    => (float) ($_POST['kriteria_layanan'] ?? 0),
                'status_rekanan'      => $_POST['status_rekanan'] ?? 'Evaluasi'
            ];

            if ($this->supplierModel->create($data)) {
                // Catat ke Audit Trail
                $this->auditModel->record('CREATE_SUPPLIER', 'SUPPLIER', 'Menambahkan rekanan baru: ' . $data['nama_perusahaan'] . ' (' . $data['kode_supplier'] . ')');
                $_SESSION['flash_success'] = 'Data rekanan supplier berhasil didaftarkan dan dievaluasi!';
                header('Location: index.php?controller=supplier&action=index');
                exit;
            } else {
                $error = 'Gagal menyimpan data ke sistem.';
                $this->view('supplier/create', ['error' => $error]);
                return;
            }
        }
        $this->view('supplier/create');
    }

    public function delete(): void {
        // Otorisasi Ketat: Hanya Admin Utama yang berhak menghapus data
        $this->requireRole(['admin']);
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0 && $this->supplierModel->delete($id)) {
            $this->auditModel->record('DELETE_SUPPLIER', 'SUPPLIER', 'Menghapus rekanan supplier dengan ID: ' . $id);
            $_SESSION['flash_success'] = 'Rekanan berhasil dihapus dari sistem pengadaan.';
        } else {
            $_SESSION['flash_error'] = 'Penghapusan gagal dilakukan.';
        }
        header('Location: index.php?controller=supplier&action=index');
        exit;
    }
}
