<?php
// Lembar P10.5: Array Asosiatif Ongkir Terintegrasi Interaksi Cepat JavaScript
$profilPaket = [
    "kode"    => "PKG-9921",
    "kota"    => "Surabaya",
    "tarifKg" => 14000,
    "asuransi"=> 5000
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Ongkos Logistik</title>
    <style>
        body { font-family: Segoe UI, sans-serif; background: #F8FAFC; padding: 20px; }
        .box { max-width: 420px; background: #FFF; border: 1px solid #E2E8F0; border-radius: 8px; padding: 18px; margin: auto; }
        input { width: 95%; padding: 8px; border: 1px solid #CBD5E1; border-radius: 4px; margin-top: 6px; }
        .hasil { font-size: 16px; font-weight: bold; color: #1D4ED8; margin-top: 12px; }
    </style>
</head>
<body>
    <div class="box">
        <h3>Ekspedisi Logistik Antar Kota</h3>
        <p>Tujuan: <strong><?= $profilPaket['kota'] ?></strong> (Rp <?= number_format($profilPaket['tarifKg'], 0, ',', '.') ?>/Kg)</p>
        <label>Berat Paket (Kg):</label>
        <input type="number" id="beratInput" value="1" min="1" oninput="kalkulasiBiaya()">
        <div class="hasil" id="tampilTotal">Total Biaya: Rp 19.000</div>
    </div>
    <script>
        const TARIF_KG = <?= $profilPaket['tarifKg'] ?>;
        const BIAYA_ASURANSI = <?= $profilPaket['asuransi'] ?>;
        function kalkulasiBiaya() {
            let berat = parseFloat(document.getElementById('beratInput').value) || 1;
            let total = (berat * TARIF_KG) + BIAYA_ASURANSI;
            document.getElementById('tampilTotal').innerText = "Total Biaya: Rp " + total.toLocaleString('id-ID');
        }
    </script>
</body>
</html>
