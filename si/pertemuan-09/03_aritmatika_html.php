<?php
// Langkah 3 (P9.3): Integrasi Aritmatika PHP ke dalam HTML
define("NAMA_TOKO", "NusaMart Retail Digital");
const PAJAK_PPN = 0.11; // 11%

$hargaDasar = 250000;
$jumlahBeli = 4;
$subtotal   = $hargaDasar * $jumlahBeli;
$totalBayar = $subtotal + ($subtotal * PAJAK_PPN);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>P9.3 - HTML + PHP</title>
</head>
<body>
    <h2>Faktur Pembelian - <?= NAMA_TOKO ?></h2>
    <p>Harga Satuan: Rp <?= number_format($hargaDasar, 0, ',', '.') ?> (<?= $jumlahBeli ?> Unit)</p>
    <p>Subtotal Belanja: Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
    <p><strong>Total Pembayaran (Termasuk PPN 11%): Rp <?= number_format($totalBayar, 0, ',', '.') ?></strong></p>
</body>
</html>
