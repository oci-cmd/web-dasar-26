<?php
// Lembar P12.1: Koneksi MySQL, Skema Kas Pabrik & SELECT Saldo
$db = mysqli_connect('localhost', 'root', '', 'db_akuntansi');
if (!$db) { die('Koneksi Gagal: ' . mysqli_connect_error()); }
mysqli_query($db, "CREATE TABLE IF NOT EXISTS buku_kas (
    id INT AUTO_INCREMENT PRIMARY KEY, no_bukti VARCHAR(20) UNIQUE, ket VARCHAR(100),
    tipe ENUM('MASUK','KELUAR'), nominal DECIMAL(12,2)) ENGINE=InnoDB");
$cek = mysqli_query($db, "SELECT COUNT(*) as tot FROM buku_kas");
if (mysqli_fetch_assoc($cek)['tot'] == 0) {
    mysqli_query($db, "INSERT INTO buku_kas (no_bukti, ket, tipe, nominal) VALUES
        ('BKM-01', 'Penerimaan Piutang Toko A', 'MASUK', 15000000),
        ('BKK-01', 'Beli Solar Genset Pabrik', 'KELUAR', 6800000),
        ('BKK-02', 'Perbaikan Conveyor Line 2', 'KELUAR', 2400000)");
}
$data = mysqli_query($db, "SELECT * FROM buku_kas ORDER BY id ASC");
$sqlSld = "SELECT SUM(CASE WHEN tipe='MASUK' THEN nominal ELSE -nominal END) as s";
$tot = mysqli_fetch_assoc(mysqli_query($db, "$sqlSld FROM buku_kas"))['s'] ?? 0;
?>
<table border="1" cellpadding="5" cellspacing="0" style="width:100%;border-collapse:collapse;">
<tr style="background:#4f46e5;color:#fff;">
  <th>ID</th><th>No Bukti</th><th>Keterangan</th><th>Tipe</th><th>Nominal</th>
</tr>
<?php while ($r = mysqli_fetch_assoc($data)): ?>
<tr><td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['no_bukti']) ?></td><td><?= htmlspecialchars($r['ket']) ?></td>
<td><?= $r['tipe'] ?></td><td align="right">Rp <?= number_format($r['nominal'], 0, ',', '.') ?></td></tr>
<?php endwhile; ?>
<tr style="background:#f1f5f9;font-weight:bold;">
  <td colspan="4">Saldo Kas Pabrik</td><td align="right">Rp <?= number_format($tot, 0, ',', '.') ?></td>
</tr>
</table>
