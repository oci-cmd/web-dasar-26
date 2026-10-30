<?php
$omzet = filter_var($_POST['omzet'] ?? '', FILTER_VALIDATE_FLOAT);
$tarif = 0.005; // Tarif PPh Final UMKM 0.5%
$pajak = null; $err = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if ($omzet === false || $omzet < 0) {
        $err = 'Nominal omzet peredaran bruto tidak valid!';
    } else {
        $pajak = $omzet * $tarif;
        $penghasilanBersih = $omzet - $pajak;
    }
}
?>
<!DOCTYPE html><html><head><title>Kalkulator PPh Final</title>
<style>
  body{font-family:sans-serif;padding:20px;background:#f8fafc}
  .card{max-width:380px;background:#fff;padding:16px;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
  input,button{width:100%;padding:8px;margin:5px 0;box-sizing:border-box}
  button{background:#1e40af;color:#fff;border:none;cursor:pointer}
  .res{background:#ecfdf5;color:#065f46;padding:10px;border-radius:4px;margin-top:10px}
  .err{background:#fee2e2;color:#b91c1c;padding:8px;border-radius:4px;margin-top:10px}
</style></head><body>
<div class="card">
  <h3>Kalkulator PPh Final UMKM (0.5%)</h3>
  <form method="POST" id="formPajak">
    <label>Peredaran Bruto / Omzet Bulanan:</label>
    <input type="number" step="any" name="omzet" id="inOmzet" placeholder="Contoh: 45000000" value="<?= htmlspecialchars($_POST['omzet'] ?? '') ?>" required>
    <button type="submit">Hitung Beban Pajak PPh</button>
  </form>
  <?php if ($err): ?><div class="err"><?= $err ?></div><?php endif; ?>
  <?php if ($pajak !== null): ?>
    <div class="res">
      <strong>Hasil Rekapitulasi Pajak:</strong><br>
      • Omzet Bruto: Rp <?= number_format($omzet, 0, ',', '.') ?><br>
      • Tarif Pajak: 0.5% (PP 55/2022)<br>
      • Beban PPh Terutang: Rp <?= number_format($pajak, 0, ',', '.') ?><br>
      • Sisa Kas Bersih: Rp <?= number_format($penghasilanBersih, 0, ',', '.') ?>
    </div>
  <?php endif; ?>
</div><script>
document.getElementById('formPajak').addEventListener('submit', function(e){
  let val = parseFloat(document.getElementById('inOmzet').value);
  if (isNaN(val) || val < 0) { alert('Harap isi nominal omzet dengan angka positif!'); e.preventDefault(); }
});
</script></body></html>
