<?php $cari = $_GET['cari'] ?? ''; ?>
<!DOCTYPE html><html><head><title>Katalog Part</title>
<style>body{font-family:sans-serif;padding:15px;background:#f4f6f8}input,button{padding:6px;border:1px solid #ccc}button{background:#0284c7;color:#fff}</style>
</head><body>
  <h3>Pencarian Suku Cadang Pabrik</h3>
  <form method="GET">
    <input type="text" id="part" name="cari" placeholder="Ketik nama part..." value="<?= $cari ?>">
    <button type="submit" onclick="return cek()">Cari</button>
  </form>
  <?php if ($cari != ''): ?>
    <p>Hasil pencarian part: <b><?= $cari ?></b></p>
  <?php endif; ?>
  <script>
    function cek() {
      if (!document.getElementById('part').value) { alert('Ketik nama part dahulu!'); return false; }
    }
  </script>
</body></html>
