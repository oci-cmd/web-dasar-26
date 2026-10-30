<?php
session_start();
$msg = '';
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = []; if (ini_get('session.use_cookies')) { setcookie(session_name(), '', time() - 42000, '/'); }
    session_destroy(); $msg = 'Sesi operator berhasil diakhiri secara aman.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['user'] ?? ''); $p = trim($_POST['pass'] ?? '');
    if ($u === 'operator' && $p === 'gudang123') {
        session_regenerate_id(true); $_SESSION['user'] = $u; $_SESSION['role'] = 'Staff Logistik';
    } else { $msg = 'Kredensial operator gudang tidak valid!'; }
}
?>
<!DOCTYPE html><html><head><title>Sistem Inventaris Pabrik</title>
<style>body{font-family:sans-serif;padding:20px;background:#f1f5f9}.box{max-width:380px;background:#fff;padding:20px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,.1)}input,button{width:100%;padding:8px;margin:5px 0;box-sizing:border-box}button{background:#1e3a8a;color:#fff;border:none;border-radius:4px;cursor:pointer}.alert{color:#dc2626;background:#fee2e2;padding:8px;border-radius:4px;margin-bottom:8px}</style>
</head><body><div class="box">
  <h3>Portal Gerbang Sesi Gudang</h3>
  <?php if (!empty($msg)): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <?php if (isset($_SESSION['user'])): ?>
    <div style="background:#ecfdf5;padding:12px;border-radius:4px;border-left:4px solid #059669">
      <p style="margin:0 0 5px 0"><b>Status Sesi: Terautentikasi Aktif</b></p>
      <small>Operator: <?= htmlspecialchars($_SESSION['user']) ?> (Role: <?= $_SESSION['role'] ?>)<br>Session ID: <?= substr(session_id(), 0, 10) ?>...</small></div>
    <p><a href="?action=logout" onclick="return confirm('Akhiri sesi kerja operator gudang?')" style="display:inline-block;padding:8px 12px;background:#dc2626;color:#fff;text-decoration:none;border-radius:4px;margin-top:10px">Terminasi Sesi (Logout)</a></p>
  <?php else: ?>
    <form method="POST">
      <input type="text" name="user" placeholder="Username Operator (operator)" required>
      <input type="password" name="pass" placeholder="Password (gudang123)" required>
      <button type="submit">Autentikasi Masuk</button></form>
  <?php endif; ?></div></body></html>
