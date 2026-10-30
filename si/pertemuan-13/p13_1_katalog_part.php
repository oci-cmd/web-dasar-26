<?php
$db = mysqli_connect('localhost', 'root', '', 'db_pabrik');
if (!$db) { die('<p>Koneksi Database Gagal!</p>'); }
mysqli_query($db, "CREATE TABLE IF NOT EXISTS tbl_part (
  id INT AUTO_INCREMENT PRIMARY KEY, kode_part VARCHAR(20) UNIQUE,
  nama_part VARCHAR(100), stok INT, harga DECIMAL(12,2)) ENGINE=InnoDB");
$cek = mysqli_query($db, "SELECT COUNT(*) as tot FROM tbl_part");
if (mysqli_fetch_assoc($cek)['tot'] == 0) {
  mysqli_query($db, "INSERT INTO tbl_part (kode_part, nama_part, stok, harga) VALUES
    ('MC-INV-01', 'Inverter VSD 5.5KW', 12, 3450000), ('MC-MTR-02', 'Motor 3-Phase 2HP', 4, 2800000)");
}
$res = mysqli_query($db, "SELECT * FROM tbl_part ORDER BY id ASC");
?>
<!DOCTYPE html><html><head><title>Katalog Suku Cadang</title>
<style>body{font-family:sans-serif;padding:20px;background:#f8fafc}table{width:100%;border-collapse:collapse;background:#fff}th,td{border:1px solid #cbd5e1;padding:8px;text-align:left}th{background:#1e3a8a;color:#fff}.alert{background:#fef2f2;color:#b91c1c;font-weight:bold}</style>
</head><body>
  <h3>Master Data Suku Cadang Mesin Pabrik</h3>
  <table>
    <tr><th>ID</th><th>Kode Part</th><th>Nama Suku Cadang</th><th>Stok</th><th>Harga Satuan</th></tr>
    <?php while ($r = mysqli_fetch_assoc($res)): ?>
    <tr class="<?= $r['stok'] <= 5 ? 'alert' : '' ?>">
      <td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['kode_part']) ?></td>
      <td><?= htmlspecialchars($r['nama_part']) ?></td>
      <td><?= $r['stok'] ?> <?= $r['stok'] <= 5 ? '(Kritis!)' : 'Unit' ?></td>
      <td>Rp <?= number_format($r['harga'], 0, ',', '.') ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</body></html>
