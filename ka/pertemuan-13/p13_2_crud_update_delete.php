<?php
// Lembar P13.2: Master Rekening Kas & Bank - UPDATE & DELETE
$db = mysqli_connect('localhost', 'root', '', 'db_akuntansi');
if (isset($_GET['aksi']) && $_GET['aksi'] === 'hapus') {
    $st = mysqli_prepare($db, "DELETE FROM master_rekening WHERE id = ?");
    $id = (int)($_GET['id'] ?? 0); mysqli_stmt_bind_param($st, "i", $id); mysqli_stmt_execute($st);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0); $nm = trim($_POST['nm'] ?? ''); $sd = (float)($_POST['sd'] ?? 0);
    $st = mysqli_prepare($db, "UPDATE master_rekening SET nama=?, tipe=?, saldo=? WHERE id=?");
    mysqli_stmt_bind_param($st, "ssdi", $nm, $_POST['tp'], $sd, $id); mysqli_stmt_execute($st);
}
$e = (isset($_GET['aksi']) && $_GET['aksi'] === 'edit') ?
    mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM master_rekening WHERE id = " . (int)$_GET['id'])) : null;
$res = mysqli_query($db, "SELECT * FROM master_rekening ORDER BY kd ASC");
?>
<?php if ($e): ?>
<form method="POST" style="font-family:sans-serif;margin-bottom:8px;background:#f8fafc;padding:5px;">
  <input type="hidden" name="id" value="<?= $e['id'] ?>"> <input name="nm" value="<?= htmlspecialchars($e['nama']) ?>" required>
  <select name="tp"><option value="KAS">Kas</option><option value="BANK" <?= $e['tipe']=='BANK'?'selected':'' ?>>Bank</option></select>
  <input type="number" step="1000" name="sd" value="<?= $e['saldo'] ?>" required> <button type="submit" style="background:#0284c7;color:#fff;border:none;padding:4px 8px;">Ubah</button>
</form>
<?php endif; ?>
<table border="1" cellpadding="5" cellspacing="0" style="font-family:sans-serif;width:100%;border-collapse:collapse;">
<tr style="background:#334155;color:#fff;"><th>Kode</th><th>Nama Rekening</th><th>Tipe</th><th>Saldo</th><th>Aksi</th></tr>
<?php while ($x = mysqli_fetch_assoc($res)): ?>
<tr><td><?= htmlspecialchars($x['kd']) ?></td><td><?= htmlspecialchars($x['nama']) ?></td><td><?= $x['tipe'] ?></td>
<td align="right">Rp <?= number_format($x['saldo'], 0, ',', '.') ?></td>
<td align="center"><a href="?aksi=edit&id=<?= $x['id'] ?>">Ubah</a> | <a href="?aksi=hapus&id=<?= $x['id'] ?>" onclick="return confirm('Hapus rekening?')">Hapus</a></td></tr>
<?php endwhile; ?></table>
