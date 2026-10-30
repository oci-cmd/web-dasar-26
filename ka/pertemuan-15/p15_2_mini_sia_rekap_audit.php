<?php
// Lembar P15.2: Mini SIA - Laporan Rekapitulasi Kas & Audit (HTML+CSS+JS+PHP+MySQL)
$db = mysqli_connect('localhost', 'root', '', 'db_akuntansi');
if (isset($_GET['aksi']) && $_GET['aksi'] === 'batal') {
    $st = mysqli_prepare($db, "DELETE FROM kas_pabrik WHERE id = ?");
    $id = (int)($_GET['id'] ?? 0); mysqli_stmt_bind_param($st, "i", $id); mysqli_stmt_execute($st);
}
$data = mysqli_query($db, "SELECT * FROM kas_pabrik ORDER BY id DESC LIMIT 10");
$tot = mysqli_fetch_assoc(mysqli_query($db, "SELECT SUM(CASE WHEN tipe='MASUK' THEN nm ELSE -nm END) as s FROM kas_pabrik"))['s'] ?? 0;
?>
<!DOCTYPE html><html><head><title>Rekap Kasir Pabrik</title>
<style>body{font-family:sans-serif;padding:20px;background:#f1f5f9}.box{max-width:680px;background:#fff;padding:16px;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.1)}table{width:100%;border-collapse:collapse;margin-top:10px}th,td{border:1px solid #cbd5e1;padding:6px;font-size:13.5px}th{background:#334155;color:#fff}.badge-m{color:#16a34a;font-weight:bold}.badge-k{color:#dc2626;font-weight:bold}.btn-del{color:#dc2626;text-decoration:none}</style>
</head><body><div class="box">
  <h3>Mini SIA: Laporan Mutasi Kas & Audit Transaksi</h3>
  <table>
    <tr><th>ID</th><th>No Bukti</th><th>Keterangan Mutasi</th><th>Tipe</th><th>Nominal</th><th>Aksi Audit</th></tr>
    <?php while ($r = mysqli_fetch_assoc($data)): ?>
    <tr>
      <td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['bk']) ?></td><td><?= htmlspecialchars($r['ket']) ?></td>
      <td class="<?= $r['tipe']==='MASUK'?'badge-m':'badge-k' ?>"><?= $r['tipe'] ?></td>
      <td align="right">Rp <?= number_format($r['nm'], 0, ',', '.') ?></td>
      <td align="center"><a href="?aksi=batal&id=<?= $r['id'] ?>" class="btn-del" onclick="return confirm('Batalkan transaksi bukti <?= $r['bk'] ?>?')">Batalkan</a></td>
    </tr>
    <?php endwhile; ?>
    <tr style="background:#f8fafc;font-weight:bold;">
      <td colspan="4">Saldo Kas Berjalan Pabrik (PSAK)</td>
      <td align="right" style="color:<?= $tot>=0?'#16a34a':'#dc2626' ?>">Rp <?= number_format($tot, 0, ',', '.') ?></td><td>Audit OK</td>
    </tr>
  </table>
</div></body></html>
