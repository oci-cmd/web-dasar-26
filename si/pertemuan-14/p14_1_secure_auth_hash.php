<?php session_start(); error_reporting(0);
// Lembar P14.1: Autentikasi CIA, BCrypt Hash, & Session Hijacking Defense
$db_user = ['user' => 'analis_si', 'role' => 'Auditor', 'hash' => password_hash('CyberSec@2026', PASSWORD_BCRYPT)];
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? ''); $p = $_POST['password'] ?? '';
    if ($u === $db_user['user'] && password_verify($p, $db_user['hash'])) {
        session_regenerate_id(true); // Mencegah Session Hijacking & Fixation
        $_SESSION['login'] = true; $_SESSION['uname'] = $u; $_SESSION['role'] = $db_user['role'];
        $msg = "<div style='color:#0f5132;background:#d1e7dd;padding:6px;margin:8px 0;'>Login Berhasil! Session ID Terproteksi.</div>";
    } else { $msg = "<div style='color:#842029;background:#f8d7da;padding:6px;margin:8px 0;'>Autentikasi Gagal! Kredensial tidak valid.</div>"; }
}
if (isset($_GET['act']) && $_GET['act'] === 'logout') { session_destroy(); header("Location: ".$_SERVER['PHP_SELF']); exit; }
?>
<!DOCTYPE html><html><head><title>P14.1 - Secure Auth & CIA</title></head>
<body style="font-family:Arial,sans-serif;background:#f4f6f9;padding:15px;margin:0;">
<div style="max-width:480px;background:#fff;border:1px solid #ccd0d5;padding:15px;border-radius:6px;margin:auto;">
  <h3 style="color:#0d3b66;margin:0 0 8px 0;border-bottom:2px solid #0d3b66;padding-bottom:5px;">P14.1: Autentikasi & Keamanan Sesi</h3>
  <p style="font-size:12px;color:#555;margin:0 0 10px 0;">Penerapan CIA Triad, BCrypt Hash, & Proteksi Session Hijacking.</p>
  <?= $msg ?>
  <?php if (!empty($_SESSION['login'])): ?>
    <div style="background:#e8f4fd;padding:10px;border-left:4px solid #0969da;font-size:13px;">
      Status: <b>Terautentikasi</b> | User: <b><?= htmlspecialchars($_SESSION['uname']) ?></b> (<?= htmlspecialchars($_SESSION['role']) ?>)<br>
      <a href="?act=logout" style="color:#d9534f;text-decoration:none;font-weight:bold;">[ Logout Aman ]</a>
    </div>
  <?php else: ?>
    <form method="POST" style="font-size:13px;">
      <label>Username:</label><input type="text" name="username" value="analis_si" required style="width:100%;padding:6px;box-sizing:border-box;margin:4px 0 8px;"><br>
      <label>Password:</label><input type="password" name="password" placeholder="CyberSec@2026" required style="width:100%;padding:6px;box-sizing:border-box;margin:4px 0 10px;"><br>
      <button type="submit" style="background:#0d3b66;color:#fff;border:none;padding:7px 14px;border-radius:4px;cursor:pointer;">Login Terverifikasi</button></form><?php endif; ?></div></body></html>
