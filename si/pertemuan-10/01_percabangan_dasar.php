<?php
// Lembar P10.1: Percabangan Dasar If-Else (Evaluasi Diskon Transaksi)
$totalBelanja = 175000;
$statusDiskon = ($totalBelanja >= 100000) ? "Dapat Diskon 10%" : "Harga Normal";
echo "Total Belanja: Rp " . number_format($totalBelanja, 0, ',', '.') . "\n";
echo "Status Promo : " . $statusDiskon;
