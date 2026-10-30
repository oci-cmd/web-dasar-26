<?php
// Langkah 5 (P9.5): Interaksi Cepat Input Kuantitas via JavaScript
$namaBarang  = "Mechanical Keyboard RGB";
$hargaSatuan = 450000;
$stokGudang  = 15;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>P9.5 - HTML + CSS + JS + PHP</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f8fafc; padding: 20px; }
        .calc-box { max-width: 420px; background: white; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; }
        input[type="number"] { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        .total { font-size: 18px; font-weight: bold; color: #0d3b66; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="calc-box">
        <h4><?= $namaBarang ?></h4>
        <p>Harga: Rp <?= number_format($hargaSatuan, 0, ',', '.') ?> (Stok: <?= $stokGudang ?>)</p>
        <label>Jumlah Beli:</label>
        <input type="number" id="qty" value="1" min="1" max="<?= $stokGudang ?>" oninput="kalkulasi()">
        <div class="total">Total: <span id="txtBayar">Rp <?= number_format($hargaSatuan, 0, ',', '.') ?></span></div>
    </div>
    <script>
        const HARGA = <?= $hargaSatuan ?>;
        function kalkulasi() {
            let jumlah = parseInt(document.getElementById('qty').value) || 0;
            let total = jumlah * HARGA;
            document.getElementById('txtBayar').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>
