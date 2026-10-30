<?php
$pt = htmlspecialchars(trim($_POST['pt'] ?? ''));
$nom = filter_var($_POST['nom'] ?? 0, FILTER_VALIDATE_FLOAT);
$disc = filter_var($_POST['disc'] ?? 0, FILTER_VALIDATE_FLOAT);
$faktur = null; $err = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if ($pt === '' || $nom <= 0) { $err = 'Nama debitur dan nominal transaksi wajib valid!'; }
    else {
        $pot = $nom * ($disc / 100);
        $dpp = $nom - $pot;
        $ppn = $dpp * 0.11;
        $faktur = ['pt' => $pt, 'sub' => $nom, 'pot' => $pot, 'ppn' => $ppn, 'tot' => ($dpp + $ppn)];
    }
}
?>
<!DOCTYPE html><html><head><title>Faktur Tagihan Finansial</title>
<style>body{font-family:sans-serif;padding:20px;background:#f8fafc}.box{max-width:400px;background:#fff;padding:16px;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.1)}input,button{width:100%;padding:8px;margin:4px 0;box-sizing:border-box}button{background:#1e3a8a;color:#fff;border:none;cursor:pointer}.inv{background:#f0fdf4;border:1px solid #86efac;padding:10px;margin-top:10px;font-size:13px}.err{background:#fee2e2;color:#b91c1c;padding:8px;margin-top:10px}</style>
</head><body><div class="box">
  <h3>Penerbitan Faktur Penjualan</h3>
  <form method="POST" id="formFaktur">
    <input type="text" name="pt" placeholder="Nama Perusahaan Client" value="<?= $pt ?>" required>
    <input type="number" step="any" name="nom" id="inNom" placeholder="Subtotal Transaksi (Rp)" value="<?= $nom ?: '' ?>" required>
    <input type="number" step="any" name="disc" placeholder="Diskon (%) Contoh: 5" value="<?= $disc ?: '' ?>">
    <button type="submit">Terbitkan Faktur Tagihan</button>
  </form>
  <?php if ($err): ?><div class="err"><?= $err ?></div><?php endif; ?>
  <?php if ($faktur): ?>
    <div class="inv">
      <b>FAKTUR TAGIHAN FINANSIAL</b><br>
      Klien: <?= $faktur['pt'] ?><br>
      Subtotal: Rp <?= number_format($faktur['sub'], 0, ',', '.') ?><br>
      Diskon: -Rp <?= number_format($faktur['pot'], 0, ',', '.') ?><br>
      PPN (11%): +Rp <?= number_format($faktur['ppn'], 0, ',', '.') ?><br>
      <strong>Total Bayar: Rp <?= number_format($faktur['tot'], 0, ',', '.') ?></strong>
    </div>
  <?php endif; ?>
</div><script>
document.getElementById('formFaktur').addEventListener('submit', function(e){
  if (parseFloat(document.getElementById('inNom').value) <= 0) { alert('Nominal harus positif!'); e.preventDefault(); }
});
</script></body></html>
