<?php
$res = null; $err = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $a = filter_var($_POST['a'] ?? '', FILTER_VALIDATE_FLOAT);
    $b = filter_var($_POST['b'] ?? '', FILTER_VALIDATE_FLOAT);
    $op = $_POST['op'] ?? '+';
    if ($a === false || $b === false) { $err = 'Input kuantitas harus angka valid!'; }
    elseif (($op === '/' || $op === '%') && $b == 0) { $err = 'Keamanan: Pembagi tidak boleh bernilai nol!'; }
    else {
        $res = match($op) {
            '+' => $a + $b, '-' => $a - $b, '*' => $a * $b,
            '/' => round($a / $b, 4), '%' => fmod($a, $b), default => 'Error'
        };
    }
}
?>
<!DOCTYPE html><html><head><title>Kalkulator Material</title>
<style>body{font-family:sans-serif;padding:15px;background:#f8fafc}.box{max-width:380px;padding:15px;background:#fff;border-radius:6px}input,select,button{width:100%;padding:8px;margin:4px 0;box-sizing:border-box}button{background:#1e40af;color:#fff;border:none;cursor:pointer}</style>
</head><body><div class="box">
  <h3>Kalkulator Batch Produksi</h3>
  <form method="POST" id="fCalc">
    <input type="number" step="any" name="a" id="valA" placeholder="Kuantitas Batch A" value="<?= htmlspecialchars($_POST['a'] ?? '') ?>" required>
    <select name="op" id="selOp">
      <option value="+">+ Gabung Batch (Tambah)</option><option value="-">- Reject/Retur (Kurang)</option>
      <option value="*">* Multi-Pallet (Kali)</option><option value="/">/ Alokasi Unit (Bagi)</option>
      <option value="%">% Modulus Sisa (Sisa Bagi)</option>
    </select>
    <input type="number" step="any" name="b" id="valB" placeholder="Kuantitas Batch B" value="<?= htmlspecialchars($_POST['b'] ?? '') ?>" required>
    <button type="submit">Hitung Beban Produksi</button>
  </form>
  <?php if ($err): ?><p style="color:#b91c1c;background:#fee2e2;padding:6px;"><?= htmlspecialchars($err) ?></p><?php endif; ?>
  <?php if ($res !== null): ?><p style="color:#065f46;background:#ecfdf5;padding:6px;"><b>Hasil:</b> <?= $res ?> Unit</p><?php endif; ?>
</div><script>
document.getElementById('fCalc').addEventListener('submit', function(e){
  let b = parseFloat(document.getElementById('valB').value);
  let op = document.getElementById('selOp').value;
  if ((op === '/' || op === '%') && b === 0) { alert('Peringatan: Nilai Batch B tidak boleh 0!'); e.preventDefault(); }
});
</script></body></html>
