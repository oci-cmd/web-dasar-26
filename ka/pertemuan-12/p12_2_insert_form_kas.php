<?php
// Lembar P12.2: Form Kasir & Prepared Statements INSERT INTO
$db = mysqli_connect('localhost', 'root', '', 'db_akuntansi');
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bk = trim($_POST['bk'] ?? ''); $kt = trim($_POST['kt'] ?? '');
    $tp = $_POST['tp'] ?? 'MASUK';  $nm = (float)($_POST['nm'] ?? 0);
    if ($bk && $nm > 0) {
        $st = mysqli_prepare($db, "INSERT INTO buku_kas (no_bukti, ket, tipe, nominal) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($st, "sssd", $bk, $kt, $tp, $nm);
        $msg = mysqli_stmt_execute($st) ? "Voucher $bk berhasil dicatat!" : "Gagal: Duplikat bukti!";
    } else { $msg = "Nomor bukti dan nominal moneter wajib valid!"; }
}
$res = mysqli_query($db, "SELECT * FROM buku_kas ORDER BY id DESC LIMIT 5");
?>
<?php if ($msg): ?><p style="color:#2563eb;font-family:sans-serif;font-weight:bold;">Status: <?= htmlspecialchars($msg) ?></p><?php endif; ?>
<form method="POST" style="font-family:sans-serif;margin-bottom:8px;">
  <input name="bk" placeholder="No Bukti" required> <input name="kt" placeholder="Keterangan Kasir" required>
  <select name="tp"><option value="MASUK">Kas Masuk</option><option value="KELUAR">Kas Keluar</option></select>
  <input type="number" step="1000" name="nm" placeholder="Nominal Rp" required>
  <button type="submit" style="background:#4f46e5;color:#fff;border:none;padding:5px 12px;cursor:pointer;">Simpan Mutasi</button>
</form>
<table border="1" cellpadding="5" cellspacing="0" style="font-family:sans-serif;width:100%;border-collapse:collapse;">
<tr style="background:#334155;color:#fff;"><th>ID</th><th>No Bukti</th><th>Keterangan</th><th>Tipe</th><th>Nominal</th></tr>
<?php while ($x = mysqli_fetch_assoc($res)): ?>
<tr><td><?= $x['id'] ?></td><td><?= htmlspecialchars($x['no_bukti']) ?></td><td><?= htmlspecialchars($x['ket']) ?></td>
<td><?= $x['tipe'] ?></td><td align="right">Rp <?= number_format($x['nominal'], 0, ',', '.') ?></td></tr>
<?php endwhile; ?>
</table>
