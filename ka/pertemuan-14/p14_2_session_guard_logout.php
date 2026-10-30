<?php
// Lembar P14.2: Session Guard Halaman Privat & Prosedur Logout
session_start();
if (isset($_GET['aksi']) && $_GET['aksi'] === 'logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) { setcookie(session_name(), '', time() - 42000, '/'); }
    session_destroy();
}
$isAuth = isset($_SESSION['kasir']);
?>
<!DOCTYPE html><html><head><title>Modul Kasir Pabrik</title>
<style>body{font-family:sans-serif;padding:20px;background:#f1f5f9}.box{max-width:480px;background:#fff;padding:16px;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.1)}table{width:100%;border-collapse:collapse;margin-top:10px}th,td{border:1px solid #cbd5e1;padding:6px}th{background:#334155;color:#fff}.btn{display:inline-block;padding:6px 12px;background:#dc2626;color:#fff;text-decoration:none;border-radius:4px;margin-top:10px}</style>
</head><body><div class="box">
  <h3>Portal Kasir Operasional Pabrik</h3>
  <?php if (!$isAuth): ?>
    <div style="background:#fee2e2;color:#991b1b;padding:12px;border-left:4px solid #dc2626;border-radius:4px;">
      <b>Akses Ditolak (Session Guard):</b> Halaman privat hanya untuk kasir terautentikasi. Silahkan login di Lembar 1.
    </div>
  <?php else: ?>
    <p>Operator: <b><?= htmlspecialchars($_SESSION['kasir']) ?></b> | Role: <b><?= $_SESSION['role'] ?></b></p>
    <table>
      <tr><th>Rekening</th><th>Tipe</th><th>Saldo Berjalan</th></tr>
      <tr><td>Kas Operasional</td><td>KAS</td><td align="right">Rp 25.000.000</td></tr>
      <tr><td>Bank Mandiri Giro</td><td>BANK</td><td align="right">Rp 85.000.000</td></tr>
      <tr><td>Bank BCA Mitra</td><td>BANK</td><td align="right">Rp 45.000.000</td></tr>
    </table>
    <a href="?aksi=logout" class="btn" onclick="return confirm('Akhiri shift kerja kasir pabrik?')">Terminasi Sesi (Logout)</a>
  <?php endif; ?>
</div></body></html>
