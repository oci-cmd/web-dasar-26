<?php
$nominal = filter_var($_POST['nominal'] ?? '', FILTER_VALIDATE_FLOAT);
$jenis = $_POST['jenis'] ?? 'D';
$ket = htmlspecialchars(trim($_POST['ket'] ?? ''));
$pesan = ''; $sukses = false;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if ($nominal === false || $nominal <= 0) {
        $pesan = 'Nominal kas harus bernilai angka lebih dari nol!';
    } elseif ($ket === '') {
        $pesan = 'Keterangan transaksi kas wajib diisi!';
    } else {
        $sukses = true;
        $pesan = 'Transaksi kas berhasil dicatat ke jurnal!';
    }
}
?>
<!DOCTYPE html><html><head><title>Entri Kas Operasional</title>
<style>
  body{font-family:sans-serif;padding:20px;background:#f8fafc}
  .card{max-width:380px;background:#fff;padding:16px;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
  input,select,button{width:100%;padding:8px;margin:5px 0;box-sizing:border-box}
  button{background:#047857;color:#fff;border:none;cursor:pointer}
  .ok{background:#ecfdf5;color:#065f46;padding:8px;border-radius:4px;margin-top:10px}
  .err{background:#fee2e2;color:#b91c1c;padding:8px;border-radius:4px;margin-top:10px}
</style></head><body>
<div class="card">
  <h3>Entri Mutasi Kas Masuk & Keluar</h3>
  <form method="POST" id="formKas">
    <select name="jenis">
      <option value="D" <?= $jenis === 'D' ? 'selected' : '' ?>>Debet (Kas Masuk / Penerimaan)</option>
      <option value="K" <?= $jenis === 'K' ? 'selected' : '' ?>>Kredit (Kas Keluar / Pengeluaran)</option>
    </select>
    <input type="number" step="any" name="nominal" id="inNominal" placeholder="Nominal Mutasi (Rp)" value="<?= htmlspecialchars($_POST['nominal'] ?? '') ?>" required>
    <input type="text" name="ket" placeholder="Keterangan Transaksi" value="<?= $ket ?>" required>
    <button type="submit">Posting Mutasi ke Jurnal</button>
  </form>
  <?php if ($pesan): ?>
    <div class="<?= $sukses ? 'ok' : 'err' ?>"><?= $pesan ?></div>
  <?php endif; ?>
</div><script>
document.getElementById('formKas').addEventListener('submit', function(e){
  let n = parseFloat(document.getElementById('inNominal').value);
  if (isNaN(n) || n <= 0) { alert('Nominal harus berupa angka positif!'); e.preventDefault(); }
});
</script></body></html>
