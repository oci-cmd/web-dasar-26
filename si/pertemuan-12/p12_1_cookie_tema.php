<?php
if (isset($_POST['theme'])) {
    setcookie('theme', $_POST['theme'], time() + 86400, '/', '', false, true);
    $_COOKIE['theme'] = $_POST['theme'];
}
$theme = $_COOKIE['theme'] ?? 'light';
$bg = $theme === 'dark' ? '#1e293b' : '#f8fafc'; $fg = $theme === 'dark' ? '#f8fafc' : '#1e293b';
?>
<!DOCTYPE html><html><head><title>Terminal Gudang</title>
<style>body{background:<?= $bg ?>;color:<?= $fg ?>;font-family:sans-serif;padding:20px;transition:.3s}.card{background:<?= $theme==='dark'?'#334155':'#fff' ?>;padding:15px;border-radius:8px;max-width:350px;box-shadow:0 2px 4px rgba(0,0,0,.1)}select,button{width:100%;padding:8px;margin-top:6px;border-radius:4px;border:1px solid #94a3b8}</style>
</head><body><div class="card">
  <h3>Terminal Logistik Gudang</h3>
  <p>Status Cookie: <b><?= htmlspecialchars($theme) ?></b></p>
  <form method="POST" id="formTema"><label>Pilih Tema Operasional:</label>
    <select name="theme" id="selTema">
      <option value="light" <?= $theme === 'light' ? 'selected' : '' ?>>Mode Terang (Siang)</option>
      <option value="dark" <?= $theme === 'dark' ? 'selected' : '' ?>>Mode Gelap (Shift Malam)</option>
    </select>
    <button type="submit" style="background:#0284c7;color:#fff;cursor:pointer">Simpan Cookie</button>
  </form></div><script>document.getElementById('formTema').onsubmit = () => alert('Preferensi tema berhasil disimpan!');</script></body></html>
