<?php
$db = mysqli_connect('localhost', 'root', '', 'db_pabrik');
$msg = '';
if (isset($_GET['del'])) {
  $stmt = mysqli_prepare($db, "DELETE FROM tbl_part WHERE id = ?");
  $id = (int)$_GET['del']; mysqli_stmt_bind_param($stmt, "i", $id); mysqli_stmt_execute($stmt); $msg = 'Data terhapus!';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kd = trim($_POST['kd'] ?? ''); $nm = trim($_POST['nm'] ?? '');
  $stok = (int)($_POST['stok'] ?? 0); $hrg = (float)($_POST['hrg'] ?? 0);
  $stmt = mysqli_prepare($db, "INSERT INTO tbl_part (kode_part, nama_part, stok, harga) VALUES (?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "ssid", $kd, $nm, $stok, $hrg);
  $msg = mysqli_stmt_execute($stmt) ? 'Part tersimpan!' : 'Gagal: Kode part duplikat!';
}
$list = mysqli_query($db, "SELECT id, kode_part, nama_part FROM tbl_part ORDER BY id DESC LIMIT 5");
?>
<!DOCTYPE html><html><head><title>Kelola Part</title>
<style>body{font-family:sans-serif;padding:15px;background:#f8fafc}.card{max-width:420px;background:#fff;padding:15px;border-radius:6px}input,button{width:100%;padding:7px;margin:3px 0;box-sizing:border-box}button{background:#047857;color:#fff;border:none;cursor:pointer}</style>
</head><body><div class="card">
  <h3>Entri Part Pabrik (Anti-SQLi)</h3>
  <?php if ($msg): ?><p style="color:#047857;background:#ecfdf5;padding:5px"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
  <form method="POST">
    <input type="text" name="kd" placeholder="Kode Part (MC-PMP-03)" required>
    <input type="text" name="nm" placeholder="Nama Suku Cadang" required>
    <input type="number" name="stok" placeholder="Stok" required><input type="number" step="any" name="hrg" placeholder="Harga" required>
    <button type="submit">Simpan Suku Cadang</button>
  </form>
  <h4>5 Part Terbaru:</h4><ul><?php while ($r = mysqli_fetch_assoc($list)): ?>
    <li><?= htmlspecialchars($r['kode_part']) ?> - <?= htmlspecialchars($r['nama_part']) ?> <a href="?del=<?= $r['id'] ?>" onclick="return confirm('Hapus?')" style="color:#dc2626">[Hapus]</a></li>
  <?php endwhile; ?></ul></div></body></html>
