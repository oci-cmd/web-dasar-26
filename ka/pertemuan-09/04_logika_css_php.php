<?php
// Langkah 4 (P9.4): Evaluasi Logika Tagihan & Styling Card CSS
$noFaktur     = "INV-2026-0891";
$totalTagihan = 850000;
$statusAudit  = ($totalTagihan >= 500000) ? "Transaksi Signifikan (Verifikasi Dosen/Pimpinan)" : "Transaksi Reguler";
$kodeVoucher  = $_GET['voucher'] ?? "TIDAK ADA VOUCHER";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>P9.4 - HTML + CSS + PHP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f6; padding: 25px; }
        .card { max-width: 480px; background: white; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.06); }
        h3 { color: #0d3b66; margin-top: 0; border-bottom: 2px solid #0d3b66; padding-bottom: 6px; }
        .badge { background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 12px; font-weight: bold; font-size: 12px; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Ringkasan Voucher Faktur</h3>
        <div class="info-row"><span>Nomor Dokumen:</span><strong>#<?= $noFaktur ?></strong></div>
        <div class="info-row"><span>Total Penjualan:</span><span>Rp <?= number_format($totalTagihan, 0, ',', '.') ?></span></div>
        <div class="info-row"><span>Status Verifikasi:</span><span class="badge"><?= $statusAudit ?></span></div>
        <div class="info-row"><span>Keterangan Voucher:</span><span><?= $kodeVoucher ?></span></div>
    </div>
</body>
</html>
