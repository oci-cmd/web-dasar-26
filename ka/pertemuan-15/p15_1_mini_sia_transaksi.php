<?php
// Lembar P15.1: Mini SIA - Formulir Entri Kasir Terpadu (HTML+CSS+JS+PHP+MySQL)
$db = mysqli_connect('localhost', 'root', '', 'db_akuntansi');
mysqli_query($db, "CREATE TABLE IF NOT EXISTS kas_pabrik (id INT AUTO_INCREMENT PRIMARY KEY,
    bk VARCHAR(20) UNIQUE, ket VARCHAR(100), tipe ENUM('MASUK','KELUAR'), nm DECIMAL(12,2)) ENGINE=InnoDB");
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bk = trim($_POST['bk'] ?? ''); $kt = trim($_POST['kt'] ?? '');
    $tp = $_POST['tp'] ?? 'MASUK';  $nm = (float)($_POST['nm'] ?? 0);
    if ($bk && $nm > 0) {
        $st = mysqli_prepare($db, "INSERT INTO kas_pabrik (bk, ket, tipe, nm) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($st, "sssd", $bk, $kt, $tp, $nm);
        $msg = mysqli_stmt_execute($st) ? "Voucher $bk berhasil dicatat!" : "Gagal: Duplikat nomor bukti!";
    } else { $msg = "Nomor bukti dan nominal moneter wajib valid!"; }
}
?>
<!DOCTYPE html><html><head><title>Entri Kasir Pabrik</title>
<style>body{font-family:sans-serif;padding:20px;background:#f8fafc}.card{max-width:440px;background:#fff;padding:16px;border:1px solid #cbd5e1;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.08)}input,select,button{width:100%;padding:7px;margin:5px 0;box-sizing:border-box}button{background:#4f46e5;color:#fff;border:none;cursor:pointer}.info{color:#0284c7;background:#e0f2fe;padding:6px;font-size:13px;border-radius:4px}</style>
</head><body><div class="card">
  <h3>Mini SIA: Entri Mutasi Kasir Pabrik</h3>
  <?php if ($msg): ?><div class="info"><b>Status:</b> <?= htmlspecialchars($msg) ?></div><?php endif; ?>
  <form method="POST" id="formKasir">
    <input name="bk" placeholder="Nomor Bukti (mis. BKM-01)" required>
    <input name="kt" placeholder="Keterangan Transaksi" required>
    <select name="tp"><option value="MASUK">Kas Masuk (Penerimaan)</option><option value="KELUAR">Kas Keluar (Pengeluaran)</option></select>
    <input type="number" step="1000" id="inNom" name="nm" placeholder="Nominal Rp" required>
    <button type="submit">Rekam Transaksi ke Jurnal</button>
  </form>
</div><script>document.getElementById('formKasir').onsubmit = (e) => { if (parseFloat(document.getElementById('inNom').value) <= 0) { alert('Nominal harus positif!'); e.preventDefault(); } };</script>
</body></html>
