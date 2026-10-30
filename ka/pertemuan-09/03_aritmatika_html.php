<?php
// Langkah 3 (P9.3): Kalkulasi Aritmatika Penjualan & PPN di HTML
define("NAMA_USAHA", "PT Nusa Prima Akuntansi");
const PAJAK_PPN = 0.11; // PPN 11%

$hargaSatuan = 350000;
$jumlahBeli  = 4;
$subtotal    = $hargaSatuan * $jumlahBeli;
$totalBayar  = $subtotal + ($subtotal * PAJAK_PPN);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>P9.3 - HTML + PHP</title>
</head>
<body>
    <h2>Faktur Penjualan - <?= NAMA_USAHA ?></h2>
    <p>Harga Satuan: Rp <?= number_format($hargaSatuan, 0, ',', '.') ?> (<?= $jumlahBeli ?> Rim)</p>
    <p>Subtotal Penjualan: Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
    <p><strong>Total Tagihan (+PPN 11%): Rp <?= number_format($totalBayar, 0, ',', '.') ?></strong></p>
</body>
</html>
