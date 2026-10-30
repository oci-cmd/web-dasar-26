<?php
$q = htmlspecialchars(trim($_GET['q'] ?? ''));
$jurnal = [
    '101' => ['nama' => 'Kas Kecil Kantor', 'saldo' => 8500000],
    '102' => ['nama' => 'Kas Bank Operasional', 'saldo' => 145000000],
    '103' => ['nama' => 'Piutang Usaha Mitra', 'saldo' => 62000000]
];
$hasil = ($q !== '' && isset($jurnal[$q])) ? $jurnal[$q] : null;
?>
<!DOCTYPE html><html><head><title>Filter Akun Jurnal</title>
<style>
  body{font-family:sans-serif;padding:20px;background:#f8fafc}
  .card{max-width:380px;background:#fff;padding:16px;border-radius:6px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
  input,button{width:100%;padding:8px;margin:5px 0;box-sizing:border-box}
  button{background:#1e40af;color:#fff;border:none;cursor:pointer}
  .res{background:#ecfdf5;color:#065f46;padding:10px;border-radius:4px;margin-top:10px}
</style></head><body>
<div class="card">
  <h3>Pencarian Akun Buku Besar</h3>
  <form method="GET" id="formCari">
    <input type="text" name="q" id="inQ" placeholder="Ketik Kode Akun (101/102/103)" value="<?= $q ?>">
    <button type="submit">Cari Saldo Rekening</button>
  </form>
  <?php if ($q !== ''): ?>
    <div class="res">
      <?php if ($hasil): ?>
        <b>Ditemukan:</b> <?= $hasil['nama'] ?><br>
        Saldo Akhir: Rp <?= number_format($hasil['saldo'], 0, ',', '.') ?>
      <?php else: ?>
        <span style="color:#b91c1c;">Kode akun <strong><?= $q ?></strong> tidak terdaftar!</span>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div><script>
document.getElementById('formCari').addEventListener('submit', function(e){
  if (!document.getElementById('inQ').value.trim()) { alert('Masukkan kode akun terlebih dahulu!'); e.preventDefault(); }
});
</script></body></html>
