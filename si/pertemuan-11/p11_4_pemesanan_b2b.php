<?php
$po = trim($_POST['po'] ?? ''); $pt = trim($_POST['pt'] ?? '');
$part = $_POST['part'] ?? 'motor'; $qty = filter_var($_POST['qty'] ?? 0, FILTER_VALIDATE_INT);
$invoice = null; $err = '';

$katalog = [
    'motor' => ['nama' => 'Motor Induksi 3-Phase', 'harga' => 4500000],
    'inverter' => ['nama' => 'Inverter Frequency VSD', 'harga' => 2800000],
    'sensor' => ['nama' => 'Flow Sensor Industri', 'harga' => 1250000]
];

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!preg_match('/^[A-Z0-9-]{5,15}$/', $po)) {
        $err = 'Format Nomor PO tidak valid! Gunakan kapital, angka, strip (anti-SQLi).';
    } elseif ($pt === '' || preg_match('/[<>\'";]/', $pt)) {
        $err = 'Nama Perusahaan tidak boleh mengandung karakter berbahaya!';
    } elseif ($qty === false || $qty < 1) {
        $err = 'Jumlah pemesanan material minimal 1 unit!';
    } else {
        $subtotal = $katalog[$part]['harga'] * $qty;
        $disc_pct = ($qty >= 50) ? 0.10 : (($qty >= 10) ? 0.05 : 0.0);
        $potongan = $subtotal * $disc_pct;
        $dpp = $subtotal - $potongan;
        $ppn = $dpp * 0.11;
        $invoice = [
            'po' => $po, 'pt' => htmlspecialchars($pt, ENT_QUOTES, 'UTF-8'),
            'item' => $katalog[$part]['nama'], 'qty' => $qty, 'sub' => $subtotal,
            'disc' => $potongan, 'disc_pct' => ($disc_pct * 100), 'ppn' => $ppn, 'tot' => ($dpp + $ppn)
        ];
    }
}
?>
<!DOCTYPE html><html><head><title>Pemesanan B2B</title>
<style>body{font-family:Arial,sans-serif;padding:20px;background:#f8fafc}.card{max-width:480px;background:#fff;padding:16px;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,.1)}input,select,button{width:100%;padding:8px;margin:4px 0;box-sizing:border-box}button{background:#1e3a8a;color:#fff;border:none;cursor:pointer}.inv{background:#f0fdf4;border:1px solid #86efac;padding:12px;margin-top:10px}.err{background:#fef2f2;border:1px solid #fca5a5;color:#b91c1c;padding:8px;margin-top:10px}</style>
</head><body><div class="card">
  <h3>Pemesanan Material B2B Pabrik</h3>
  <form method="POST" id="formPO">
    <input type="text" name="po" id="inPo" placeholder="No. PO (Contoh: PO-IND-2026)" value="<?= htmlspecialchars($po) ?>" required>
    <input type="text" name="pt" placeholder="Nama Perusahaan Client" value="<?= htmlspecialchars($pt) ?>" required>
    <select name="part">
      <?php foreach ($katalog as $k => $v): ?>
        <option value="<?= $k ?>" <?= $part === $k ? 'selected' : '' ?>><?= $v['nama'] ?> (Rp <?= number_format($v['harga'], 0, ',', '.') ?>)</option>
      <?php endforeach; ?>
    </select>
    <input type="number" name="qty" placeholder="Jumlah Pesanan (Unit)" value="<?= htmlspecialchars((string)($qty ?: '')) ?>" min="1" required>
    <button type="submit">Terbitkan Purchase Order</button>
  </form>
  <?php if ($err): ?><div class="err"><?= $err ?></div><?php endif; ?>
  <?php if ($invoice): ?>
    <div class="inv">
      <h4 style="margin:0 0 6px 0;">FAKTUR PEMESANAN: <?= $invoice['po'] ?></h4>
      Perusahaan: <b><?= $invoice['pt'] ?></b><br>
      Item: <?= $invoice['item'] ?> (x<?= $invoice['qty'] ?>)<br>
      Subtotal: Rp <?= number_format($invoice['sub'], 0, ',', '.') ?><br>
      Diskon Grosir (<?= $invoice['disc_pct'] ?>%): -Rp <?= number_format($invoice['disc'], 0, ',', '.') ?><br>
      PPN Masukan (11%): +Rp <?= number_format($invoice['ppn'], 0, ',', '.') ?><br>
      <strong>Total Bayar: Rp <?= number_format($invoice['tot'], 0, ',', '.') ?></strong>
    </div>
  <?php endif; ?>
</div><script>
document.getElementById('formPO').addEventListener('submit', function(e){
  if (!/^[A-Z0-9-]{5,15}$/.test(document.getElementById('inPo').value.trim())) {
    alert('Format No PO wajib huruf kapital, angka, atau tanda minus!');
    e.preventDefault();
  }
});
</script></body></html>
