<?php
// Lembar P13.1: Master Rekening Kas & Bank - CREATE & READ
$db = mysqli_connect('localhost', 'root', '', 'db_akuntansi');
mysqli_query($db, "CREATE TABLE IF NOT EXISTS master_rekening (id INT AUTO_INCREMENT PRIMARY KEY,
    kd VARCHAR(10) UNIQUE, nama VARCHAR(50), tipe ENUM('KAS','BANK'), saldo DECIMAL(12,2)) ENGINE=InnoDB");
if (mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as t FROM master_rekening"))['t'] == 0) {
    mysqli_query($db, "INSERT INTO master_rekening (kd, nama, tipe, saldo) VALUES
        ('101', 'Kas Operasional Pabrik', 'KAS', 25000000), ('102', 'Bank Mandiri', 'BANK', 85000000)");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kd = trim($_POST['kd'] ?? ''); $nm = trim($_POST['nm'] ?? '');
    $tp = $_POST['tp'] ?? 'KAS';    $sd = (float)($_POST['sd'] ?? 0);
    if ($kd && $nm) {
        $st = mysqli_prepare($db, "INSERT INTO master_rekening (kd, nama, tipe, saldo) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($st, "sssd", $kd, $nm, $tp, $sd); mysqli_stmt_execute($st);
    }
}
$data = mysqli_query($db, "SELECT * FROM master_rekening ORDER BY kd ASC");
?>
<form method="POST" style="font-family:sans-serif;margin-bottom:8px;">
  <input name="kd" placeholder="Kode Akun" required style="width:80px;"> <input name="nm" placeholder="Nama Rekening" required>
  <select name="tp"><option value="KAS">Kas</option><option value="BANK">Bank</option></select> <input type="number" step="1000" name="sd" placeholder="Saldo Rp" required>
  <button type="submit" style="background:#4f46e5;color:#fff;border:none;padding:5px 12px;cursor:pointer;">Simpan Rekening</button>
</form>
<table border="1" cellpadding="5" cellspacing="0" style="font-family:sans-serif;width:100%;border-collapse:collapse;">
<tr style="background:#334155;color:#fff;"><th>ID</th><th>Kode</th><th>Nama Rekening</th><th>Tipe</th><th>Saldo</th></tr>
<?php while ($r = mysqli_fetch_assoc($data)): ?>
<tr><td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['kd']) ?></td><td><?= htmlspecialchars($r['nama']) ?></td>
<td><?= $r['tipe'] ?></td><td align="right">Rp <?= number_format($r['saldo'], 0, ',', '.') ?></td></tr>
<?php endwhile; ?></table>
