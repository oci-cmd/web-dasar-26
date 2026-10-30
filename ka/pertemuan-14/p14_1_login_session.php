<?php
// Lembar P14.1: Autentikasi Login Kasir & Inisialisasi Sesi
session_start(); $msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['user'] ?? ''); $p = trim($_POST['pass'] ?? '');
    if ($u === 'kasir_pabrik' && $p === 'kasir123') {
        session_regenerate_id(true);
        $_SESSION['kasir'] = $u; $_SESSION['role'] = 'Kasir Operasional Pabrik';
        $_SESSION['masuk'] = date('H:i:s d-m-Y');
    } else { $msg = 'Kredensial username atau password kasir tidak valid!'; }
}
?>
<!DOCTYPE html><html><head><title>Login Kasir Pabrik</title>
<style>body{font-family:sans-serif;padding:20px;background:#f8fafc}.card{max-width:360px;background:#fff;padding:16px;border:1px solid #cbd5e1;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.08)}input,button{width:100%;padding:7px;margin:5px 0;box-sizing:border-box}button{background:#4f46e5;color:#fff;border:none;cursor:pointer}.err{color:#dc2626;background:#fee2e2;padding:6px;font-size:13px;border-radius:4px}</style>
</head><body><div class="card">
  <h3>Portal Autentikasi Kasir</h3>
  <?php if ($msg): ?><div class="err"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if (isset($_SESSION['kasir'])): ?>
    <div style="background:#ecfdf5;color:#065f46;padding:10px;border-radius:4px;">
      <b>Status: Terautentikasi Aktif</b><br>
      <small>Operator: <?= htmlspecialchars($_SESSION['kasir']) ?> (<?= $_SESSION['role'] ?>)<br>Waktu: <?= $_SESSION['masuk'] ?> | ID: <?= substr(session_id(), 0, 8) ?>...</small>
    </div>
  <?php else: ?>
    <form method="POST">
      <input name="user" placeholder="Username Kasir (kasir_pabrik)" required autocomplete="off">
      <input type="password" name="pass" placeholder="Password (kasir123)" required>
      <button type="submit">Autentikasi Shift Masuk</button>
    </form>
  <?php endif; ?>
</div></body></html>
