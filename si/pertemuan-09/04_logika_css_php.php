<?php
// Langkah 4 (P9.4): Evaluasi Logika Bisnis & Styling Card CSS
$idMember     = 1005;
$totalBelanja = 750000;
$statusMember = ($totalBelanja >= 500000) ? "Pelanggan VIP Platinum" : "Pelanggan Reguler";
$voucherHemat = $_GET['voucher'] ?? "TIDAK ADA VOUCHER";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>P9.4 - HTML + CSS + PHP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f6; padding: 25px; }
        .card { max-width: 450px; background: white; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.06); }
        h3 { color: #0d3b66; margin-top: 0; border-bottom: 2px solid #0d3b66; padding-bottom: 6px; }
        .badge { background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 12px; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Ringkasan Akun Member</h3>
        <div class="info-row"><span>ID Pelanggan:</span><strong>#<?= $idMember ?></strong></div>
        <div class="info-row"><span>Total Belanja:</span><span>Rp <?= number_format($totalBelanja, 0, ',', '.') ?></span></div>
        <div class="info-row"><span>Status Loyalitas:</span><span class="badge"><?= $statusMember ?></span></div>
        <div class="info-row"><span>Kode Voucher:</span><span><?= $voucherHemat ?></span></div>
    </div>
</body>
</html>
