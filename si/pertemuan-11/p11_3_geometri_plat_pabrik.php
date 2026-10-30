<?php
$tipe = $_POST['tipe'] ?? 'persegi';
$p = filter_var($_POST['panjang'] ?? '', FILTER_VALIDATE_FLOAT);
$l = filter_var($_POST['lebar'] ?? '', FILTER_VALIDATE_FLOAT);
$r = filter_var($_POST['radius'] ?? '', FILTER_VALIDATE_FLOAT);
$luas = null; $kel = null; $err = '';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if ($tipe === 'persegi') {
        if ($p === false || $p <= 0 || $l === false || $l <= 0) {
            $err = 'Panjang dan lebar plat harus bernilai lebih dari 0!';
        } else {
            $luas = $p * $l;
            $kel = 2 * ($p + $l);
        }
    } elseif ($tipe === 'lingkaran') {
        if ($r === false || $r <= 0) {
            $err = 'Jari-jari lingkaran plat harus bernilai lebih dari 0!';
        } else {
            $luas = pi() * pow($r, 2);
            $kel = 2 * pi() * $r;
        }
    }
}
?>
<!DOCTYPE html><html><head><title>Geometri Fabrikasi</title>
<style>
  body{font-family:Arial,sans-serif;padding:20px;background:#f1f5f9}
  .card{max-width:440px;background:#fff;padding:18px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
  input,select,button{width:100%;padding:8px;margin:5px 0;box-sizing:border-box}
  button{background:#047857;color:#fff;border:none;border-radius:4px;cursor:pointer}
  .res{background:#f0fdf4;border-left:4px solid #047857;padding:10px;margin-top:12px}
  .err{background:#fef2f2;border-left:4px solid #dc2626;color:#b91c1c;padding:10px;margin-top:12px}
</style></head><body>
<div class="card">
  <h3>Fabrikasi Plat Lantai Pabrik</h3>
  <form method="POST">
    <label>Bentuk Geometri Plat:</label>
    <select name="tipe" id="tipeGeometri" onchange="gantiBentuk()">
      <option value="persegi" <?= $tipe === 'persegi' ? 'selected' : '' ?>>Persegi Panjang (Plat Lembaran)</option>
      <option value="lingkaran" <?= $tipe === 'lingkaran' ? 'selected' : '' ?>>Lingkaran (Tutup Tangki Industri)</option>
    </select>
    <div id="boxPersegi">
      <input type="number" step="any" name="panjang" placeholder="Panjang plat (meter)" value="<?= htmlspecialchars($_POST['panjang'] ?? '') ?>">
      <input type="number" step="any" name="lebar" placeholder="Lebar plat (meter)" value="<?= htmlspecialchars($_POST['lebar'] ?? '') ?>">
    </div>
    <div id="boxLingkaran" style="display:none;">
      <input type="number" step="any" name="radius" placeholder="Jari-jari plat (meter)" value="<?= htmlspecialchars($_POST['radius'] ?? '') ?>">
    </div>
    <button type="submit">Hitung Luas & Keliling</button>
  </form>
  <?php if ($err): ?><div class="err"><?= htmlspecialchars($err) ?></div><?php endif; ?>
  <?php if ($luas !== null): ?>
    <div class="res">
      <strong>Hasil Komputasi Dimensi Plat:</strong><br>
      • Luas Penampang: <?= number_format($luas, 2) ?> m²<br>
      • Keliling Keliling: <?= number_format($kel, 2) ?> m
    </div>
  <?php endif; ?>
</div>
<script>
function gantiBentuk() {
  let val = document.getElementById('tipeGeometri').value;
  document.getElementById('boxPersegi').style.display = (val === 'persegi') ? 'block' : 'none';
  document.getElementById('boxLingkaran').style.display = (val === 'lingkaran') ? 'block' : 'none';
}
window.onload = gantiBentuk;
</script></body></html>
